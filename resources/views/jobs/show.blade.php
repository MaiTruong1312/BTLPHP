@extends('layouts.app')

@section('title', $job->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-md p-8 mb-6">
        <div class="flex justify-between items-start mb-4">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $job->title }}</h1>
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">{{ $job->category->name }}</span>
                    <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">{{ $job->location->city }}</span>
                    <span class="px-3 py-1 bg-purple-100 text-purple-800 text-sm rounded-full">{{ ucfirst(str_replace('_', ' ', $job->job_type)) }}</span>
                    @if($job->is_remote)
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-full">Remote</span>
                    @endif
                </div>
            </div>
            @auth
                @if(auth()->user()->isCandidate())
                    <div class="flex gap-2">
                        <form action="{{ route('saved-jobs.store', $job) }}" method="POST" class="inline">
                            @csrf
                            @if($isSaved)
                                <button type="submit" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Saved</button>
                            @else
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Job</button>
                            @endif
                        </form>
                    </div>
                @endif
            @endauth
        </div>

        @if($job->employerProfile)
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="font-semibold text-lg mb-2">{{ $job->employerProfile->company_name }}</h3>
                <p class="text-gray-600">{{ $job->employerProfile->about ?? 'No company description available.' }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="font-semibold text-lg mb-2">Salary</h3>
                <p class="text-gray-700">
                    @if($job->salary_min && $job->salary_max)
                        {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} {{ $job->currency }}/{{ $job->salary_type }}
                    @elseif($job->salary_min)
                        From {{ number_format($job->salary_min) }} {{ $job->currency }}/{{ $job->salary_type }}
                    @else
                        Negotiable
                    @endif
                </p>
            </div>
            <div>
                <h3 class="font-semibold text-lg mb-2">Experience Level</h3>
                <p class="text-gray-700">{{ $job->experience_level ? ucfirst($job->experience_level) : 'Not specified' }}</p>
            </div>
            <div>
                <h3 class="font-semibold text-lg mb-2">Vacancies</h3>
                <p class="text-gray-700">{{ $job->vacancies }} position(s)</p>
            </div>
            @if($job->deadline)
                <div>
                    <h3 class="font-semibold text-lg mb-2">Application Deadline</h3>
                    <p class="text-gray-700">{{ $job->deadline->format('F d, Y') }}</p>
                </div>
            @endif
        </div>

        @if($job->skills->count() > 0)
            <div class="mb-6">
                <h3 class="font-semibold text-lg mb-2">Required Skills</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($job->skills as $skill)
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm rounded-full">{{ $skill->name }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-2">Job Description</h3>
            <div class="text-gray-700 prose max-w-none">
                {!! nl2br(e($job->description)) !!}
            </div>
        </div>

        @if($job->requirements)
            <div class="mb-6">
                <h3 class="font-semibold text-lg mb-2">Requirements</h3>
                <div class="text-gray-700 prose max-w-none">
                    {!! nl2br(e($job->requirements)) !!}
                </div>
            </div>
        @endif

        @auth
            @if(auth()->user()->isCandidate() && !$hasApplied)
                <div class="mt-8 p-6 bg-blue-50 rounded-lg">
                    <h3 class="font-semibold text-lg mb-4">Apply for this position</h3>
                    <form action="{{ route('applications.store', $job) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="cover_letter" class="block text-gray-700 text-sm font-bold mb-2">Cover Letter</label>
                            <textarea name="cover_letter" id="cover_letter" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('cover_letter') }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="cv" class="block text-gray-700 text-sm font-bold mb-2">Upload CV (PDF, DOC, DOCX - Max 5MB)</label>
                            <input type="file" name="cv" id="cv" accept=".pdf,.doc,.docx" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <p class="text-sm text-gray-500 mt-1">If you don't upload a CV, we'll use your profile CV if available.</p>
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                            Submit Application
                        </button>
                    </form>
                </div>
            @elseif(auth()->user()->isCandidate() && $hasApplied)
                <div class="mt-8 p-6 bg-green-50 rounded-lg">
                    <p class="text-green-800 font-semibold">You have already applied for this position.</p>
                </div>
            @endif
        @else
            <div class="mt-8 p-6 bg-gray-50 rounded-lg text-center">
                <p class="text-gray-700 mb-4">Please <a href="{{ route('login') }}" class="text-blue-600 hover:underline">login</a> or <a href="{{ route('register') }}" class="text-blue-600 hover:underline">register</a> to apply for this job.</p>
            </div>
        @endauth
    </div>
</div>
@endsection

