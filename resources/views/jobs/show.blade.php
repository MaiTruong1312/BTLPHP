@extends('layouts.app')

@section('title', $job->title)

@section('content')
<div class="bg-gray-50 min-h-screen py-10 relative overflow-hidden">

    {{-- Soft background shapes --}}
    <div class="absolute inset-0 -z-10 opacity-30">
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-blue-200 blur-3xl rounded-full"></div>
        <div class="absolute top-1/3 -right-20 w-64 h-64 bg-indigo-200 blur-3xl rounded-full"></div>
        <div class="absolute bottom-0 left-1/3 w-72 h-72 bg-blue-100 blur-3xl rounded-full"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- MAIN CARD --}}
        <div class="bg-white shadow-lg rounded-2xl p-8 relative overflow-hidden mb-10 border border-gray-100">

            {{-- HEADER Section --}}
            <div class="flex flex-col lg:flex-row justify-between gap-6">
                <div class="flex-1 space-y-4">

                    {{-- TITLE --}}
                    <h1 class="text-4xl font-bold text-gray-900 leading-tight">
                        {{ $job->title }}
                    </h1>

                    {{-- TAGS --}}
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">{{ $job->category->name }}</span>
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">{{ $job->location->city }}</span>
                        <span class="px-3 py-1 bg-purple-100 text-purple-800 text-sm rounded-full">{{ ucfirst(str_replace('_', ' ', $job->job_type)) }}</span>
                        @if($job->is_remote)
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-full">Remote</span>
                        @endif
                    </div>

                    {{-- CREATED TIME --}}
                    <p class="text-gray-500 text-sm flex items-center gap-1">
                        ⏱ Posted {{ $job->created_at->diffForHumans() }}
                    </p>
                </div>

                {{-- SAVE JOB --}}
                @auth
                    @if(auth()->user()->isCandidate())
                        <div class="flex items-start lg:items-center gap-3">
                            <form action="{{ route('saved-jobs.store', $job) }}" method="POST">
                                @csrf
                                @if($isSaved)
                                    <button class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg">
                                        ✔ Saved
                                    </button>
                                @else
                                    <button class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg">
                                        ⭐ Save Job
                                    </button>
                                @endif
                            </form>
                        </div>
                    @endif
                @endauth
            </div>

            {{-- COMPANY INFO --}}
            @if($job->employerProfile)
                <div class="mt-6 p-5 bg-blue-50 rounded-xl border-l-4 border-blue-400 shadow-sm">
                    <h3 class="font-semibold text-xl mb-1 text-gray-800">
                        {{ $job->employerProfile->company_name }}
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $job->employerProfile->about ?? 'No company description available.' }}
                    </p>
                </div>
            @endif

            {{-- JOB INFORMATION GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-10">

                <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">💰 Salary</h3>
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

                <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">🎓 Experience Level</h3>
                    <p class="text-gray-700">{{ $job->experience_level ? ucfirst($job->experience_level) : 'Not specified' }}</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">👥 Vacancies</h3>
                    <p class="text-gray-700">{{ $job->vacancies }} position(s)</p>
                </div>

                @if($job->deadline)
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">📅 Application Deadline</h3>
                        <p class="text-gray-700">{{ $job->deadline->format('F d, Y') }}</p>
                    </div>
                @endif
            </div>

            {{-- SKILLS --}}
            @if($job->skills->count() > 0)
                <div class="mt-10">
                    <h3 class="text-xl font-semibold mb-3 text-gray-900">🔥 Required Skills</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($job->skills as $skill)
                            <span class="px-4 py-1.5 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium shadow-sm">
                                {{ $skill->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- DESCRIPTION --}}
            <div class="mt-10">
                <h3 class="text-xl font-semibold mb-4 text-gray-900">📝 Job Description</h3>
                <div class="prose max-w-none text-gray-700 leading-relaxed bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                    {!! nl2br(e($job->description)) !!}
                </div>
            </div>

            {{-- REQUIREMENTS --}}
            @if($job->requirements)
                <div class="mt-10">
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">📌 Requirements</h3>
                    <div class="prose max-w-none text-gray-700 leading-relaxed bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                        {!! nl2br(e($job->requirements)) !!}
                    </div>
                </div>
            @endif

            {{-- APPLY FORM --}}
            @auth
                @if(auth()->user()->isCandidate() && !$hasApplied)
                    <div class="mt-12 bg-blue-50 p-8 rounded-2xl border border-blue-200 shadow-lg">

                        <h3 class="text-2xl font-bold mb-6 text-blue-700">🚀 Apply for this position</h3>

                        <form action="{{ route('applications.store', $job) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-6">
                                <label for="cover_letter" class="block text-gray-700 font-semibold mb-2">Cover Letter</label>
                                <textarea name="cover_letter" rows="5"
                                          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 px-4 py-3"
                                >{{ old('cover_letter') }}</textarea>
                            </div>

                            <div class="mb-6">
                                <label for="cv" class="block text-gray-700 font-semibold mb-2">Upload CV</label>
                                <input type="file" name="cv" accept=".pdf,.doc,.docx"
                                       class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring focus:ring-blue-200">
                                <p class="text-sm text-gray-500 mt-1">If not uploaded, we will use your profile CV.</p>
                            </div>

                            <button class="mt-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md">
                                Submit Application
                            </button>
                        </form>
                    </div>

                @elseif(auth()->user()->isCandidate() && $hasApplied)
                    <div class="mt-12 p-6 bg-green-100 border-l-4 border-green-500 rounded-xl text-green-800">
                        ✔ You have already applied for this job.
                    </div>
                @endif

            @else
                <div class="mt-10 p-6 bg-gray-50 rounded-xl text-center border border-gray-200 shadow-sm">
                    <p class="text-gray-700">
                        Please <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">login</a>
                        or
                        <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-semibold">register</a>
                        to apply for this job.
                    </p>
                </div>
            @endauth

            {{-- COMMENT LIST --}}
            <div class="mt-12">
                <h3 class="text-2xl font-semibold mb-4">💬 Comments ({{ $comments->total() }})</h3>

                <div class="space-y-5">
                    @forelse($comments as $comment)
                        @include('jobs._comment', ['comment' => $comment])
                    @empty
                        <p class="text-gray-500">Chưa có bình luận nào.</p>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $comments->links() }}
                </div>
            </div>
        </div>

        {{-- COMMENT FORM --}}
        @auth
            <div class="bg-white shadow-md rounded-xl p-6 border border-gray-100">
                <h3 class="text-xl font-semibold mb-3">✍️ Để lại bình luận</h3>

                <form action="{{ route('comments.store', $job) }}" method="POST">
                    @csrf

                    <textarea name="content" rows="4"
                              class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 px-4 py-3"
                              placeholder="Viết bình luận của bạn..." required></textarea>

                    <button
                        class="mt-4 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium shadow-md">
                        Gửi bình luận
                    </button>
                </form>
            </div>
        @else
            <div class="text-center mt-6">
                <p>
                    Vui lòng <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">đăng nhập</a>
                    để để lại bình luận.
                </p>
            </div>
        @endauth
    </div>
</div>
@endsection
