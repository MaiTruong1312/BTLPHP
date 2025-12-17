@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="text-sm mb-6">
            <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-800">Dashboard</a>
            <span class="mx-2 text-gray-500">/</span>
            <span class="text-gray-500">Application #{{ $application->id }}</span>
        </nav>

        <!-- Notifications -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Left Column: Application Info -->
            <div class="md:col-span-2 space-y-6">
                <!-- Applicant Details Card -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Applicant Information
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Applied for <a href="{{ route('jobs.show', $application->job->slug) }}" class="text-indigo-600 hover:underline">{{ $application->job->title }}</a>
                        </p>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Full name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $application->user->name }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $application->user->email }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $application->candidateProfile->phone ?? 'N/A' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Applied At</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $application->applied_at->format('M d, Y H:i') }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Cover Letter</dt>
                                <dd class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded border border-gray-200">
                                    {{ $application->cover_letter ?? 'No cover letter provided.' }}
                                </dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Attachments</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if($application->cv_path)
                                        <a href="{{ Storage::url($application->cv_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Download CV
                                        </a>
                                    @else
                                        <span class="text-gray-500 italic">No CV attached</span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Right Column: Actions -->
            <div class="md:col-span-1 space-y-6">
                                <!-- Current Interview Info (If exists) -->
                @if($application->interview)
                <div class="bg-white shadow sm:rounded-lg mt-6">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200 bg-indigo-50">
                        <h3 class="text-lg font-medium text-indigo-900">Scheduled Interview</h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6 text-sm">
                        <p><strong>Time:</strong> {{ $application->interview->scheduled_at->format('M d, Y H:i') }}</p>
                        <p><strong>Type:</strong> <span class="uppercase">{{ $application->interview->type }}</span></p>
                        <p><strong>Location:</strong> 
                            @if($application->interview->type == 'online')
                                <a href="{{ $application->interview->location }}" target="_blank" class="text-indigo-600 hover:underline">{{ $application->interview->location }}</a>
                            @else
                                {{ $application->interview->location }}
                            @endif
                        </p>
                        @if($application->interview->notes)
                            <p class="mt-2"><strong>Notes:</strong> {{ $application->interview->notes }}</p>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status');
        const interviewFields = document.getElementById('interview-fields');
        const rejectionFields = document.getElementById('rejection-fields');

        function toggleFields() {
            const status = statusSelect.value;
            
            // Toggle Interview Fields
            if (status === 'interview') {
                interviewFields.classList.remove('hidden');
            } else {
                interviewFields.classList.add('hidden');
            }

            // Toggle Rejection Fields
            if (status === 'rejected') {
                rejectionFields.classList.remove('hidden');
            } else {
                rejectionFields.classList.add('hidden');
            }
        }

        // Initial check
        toggleFields();

        // Listen for changes
        statusSelect.addEventListener('change', toggleFields);
    });
</script>
@endsection