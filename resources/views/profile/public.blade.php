@extends('layouts.app')

@section('title', $user->name . ' - Profile')

@section('content')
<div class="bg-gray-100">
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Profile Header -->
            <div class="p-8 bg-blue-600 text-white">
                <div class="flex flex-col md:flex-row items-center">
                    <img class="h-24 w-24 rounded-full object-cover border-4 border-white" src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="Profile picture">
                    <div class="mt-4 md:mt-0 md:ml-6 text-center md:text-left">
                        <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                        <p class="text-blue-200">{{ $user->email }}</p>
                        @if($user->candidateProfile->address)
                            <p class="text-sm text-blue-100 mt-1">{{ $user->candidateProfile->address }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="p-8">
                <!-- Summary -->
                @if($user->candidateProfile->summary)
                <div class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Summary</h2>
                    <p class="text-gray-600 leading-relaxed">{{ $user->candidateProfile->summary }}</p>
                </div>
                @endif

                <!-- Skills -->
                @if($user->candidateProfile->skills->isNotEmpty())
                <div class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Skills</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($user->candidateProfile->skills as $skill)
                            <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">{{ $skill->name }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Experience -->
                @if($user->candidateProfile->experiences->isNotEmpty())
                <div class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Work Experience</h2>
                    <div class="space-y-6 border-l-2 border-gray-200 pl-6">
                        @foreach($user->candidateProfile->experiences as $experience)
                        <div class="relative">
                            <div class="absolute -left-7 w-4 h-4 bg-blue-600 rounded-full"></div>
                            <p class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($experience->start_date)->format('M Y') }} - 
                                @if($experience->is_current)
                                    Present
                                @else
                                    {{ \Carbon\Carbon::parse($experience->end_date)->format('M Y') }}
                                @endif
                            </p>
                            <h3 class="text-xl font-bold text-gray-900 mt-1">{{ $experience->position }}</h3>
                            <p class="text-md text-gray-700">{{ $experience->company_name }}</p>
                            @if($experience->description)
                            <p class="text-gray-600 mt-2">{{ $experience->description }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Education -->
                @if($user->candidateProfile->educations->isNotEmpty())
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Education</h2>
                    <div class="space-y-6 border-l-2 border-gray-200 pl-6">
                        @foreach($user->candidateProfile->educations as $education)
                        <div class="relative">
                            <div class="absolute -left-7 w-4 h-4 bg-blue-600 rounded-full"></div>
                            <p class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($education->start_date)->format('M Y') }} - 
                                {{ $education->end_date ? \Carbon\Carbon::parse($education->end_date)->format('M Y') : 'Present' }}
                            </p>
                            <h3 class="text-xl font-bold text-gray-900 mt-1">{{ $education->school_name }}</h3>
                            <p class="text-md text-gray-700">{{ $education->degree }}, {{ $education->field_of_study }}</p>
                            @if($education->description)
                            <p class="text-gray-600 mt-2">{{ $education->description }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection