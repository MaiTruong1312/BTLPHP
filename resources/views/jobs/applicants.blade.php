@extends('layouts.app')

@section('title', 'Applicants for ' . $job->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-6 border-b pb-4">
            <h1 class="text-3xl font-bold">Applicants for "{{ $job->title }}"</h1>
            <p class="text-gray-600 mt-2">A total of <span class="font-semibold">{{ $applications->total() }}</span> candidate(s) have applied for this position.</p>
        </div>

        @if($applications->count() > 0)
            <div class="space-y-6">
                @foreach($applications as $application)
                    <div class="flex items-start justify-between p-4 rounded-lg border hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-start space-x-4">
                            <img class="h-12 w-12 rounded-full object-cover" src="{{ $application->user->avatar ? asset('storage/' . $application->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($application->user->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ $application->user->name }}">
                            <div>
                                <a href="{{ route('profile.public.show', ['user' => $application->user->id]) }}" class="text-lg font-semibold text-blue-600 hover:underline">
                                    {{ $application->user->name }}
                                </a>
                                <p class="text-sm text-gray-600">{{ $application->user->email }}</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Applied: {{ $application->applied_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            @if($application->cv_path)
                                <a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    View CV
                                </a>
                            @else
                                <span class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-gray-50">
                                    No CV attached
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $applications->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No applicants yet</h3>
                <p class="mt-1 text-sm text-gray-500">Check back later to see who has applied for this job.</p>
            </div>
        @endif
    </div>
</div>
@endsection
