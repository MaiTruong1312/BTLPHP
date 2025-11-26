@extends('layouts.app')

@section('title', 'Application Details')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-6">Application Details</h1>

    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold mb-2">
                <a href="{{ route('jobs.show', $application->job->slug) }}" class="text-blue-600 hover:underline">{{ $application->job->title }}</a>
            </h2>
            <p class="text-gray-600">{{ $application->job->employerProfile->company_name ?? 'Company' }}</p>
        </div>

        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-2">Application Status</h3>
            <span class="px-4 py-2 rounded-full {{ $application->status == 'offered' ? 'bg-green-100 text-green-800' : ($application->status == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                {{ ucfirst($application->status) }}
            </span>
        </div>

        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-2">Applied On</h3>
            <p class="text-gray-700">{{ $application->applied_at->format('F d, Y \a\t g:i A') }}</p>
        </div>

        @if($application->cover_letter)
            <div class="mb-6">
                <h3 class="font-semibold text-lg mb-2">Cover Letter</h3>
                <div class="text-gray-700 prose max-w-none bg-gray-50 p-4 rounded">
                    {!! nl2br(e($application->cover_letter)) !!}
                </div>
            </div>
        @endif

        @if($application->cv_path)
            <div class="mb-6">
                <h3 class="font-semibold text-lg mb-2">CV</h3>
                <a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank" class="text-blue-600 hover:underline">View CV</a>
            </div>
        @endif

        <div class="flex gap-4">
            <a href="{{ route('jobs.show', $application->job->slug) }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">View Job</a>
            <a href="{{ route('applications.index') }}" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700">Back to Applications</a>
        </div>
    </div>
</div>
@endsection

