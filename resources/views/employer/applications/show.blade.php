@extends('layouts.app')

@section('title', 'Application Details')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('employer.interviews.index') }}" class="text-indigo-600 hover:text-indigo-800">← Back to Interviews</a>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">Application Details</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Applied for <span class="font-bold">{{ $application->job->title }}</span></p>
            </div>
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                {{ $application->status === 'interview' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                {{ ucfirst($application->status) }}
            </span>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Candidate Name</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $application->user->name }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $application->user->email }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Cover Letter</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 whitespace-pre-line">{{ $application->cover_letter ?? 'No cover letter provided.' }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">CV / Resume</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if($application->cv_path)
                            <a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank" class="font-medium text-indigo-600 hover:text-indigo-500">
                                Download CV
                            </a>
                        @else
                            <span class="text-gray-400">No CV uploaded</span>
                        @endif
                    </dd>
                </div>
                @if($application->candidateProfile)
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Profile Summary</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $application->candidateProfile->summary }}
                    </dd>
                </div>
                @endif
            </dl>
        </div>
    </div>

    <!-- Application History / Audit Log -->
    <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Application History</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Timeline of status changes and actions.</p>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
            <div class="flow-root">
                <ul role="list" class="-mb-8">
                    @forelse($histories as $history)
                        <li>
                            <div class="relative pb-8">
                                @if(!$loop->last)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center ring-8 ring-white">
                                            <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Changed status from <span class="font-medium text-gray-900">{{ ucfirst($history->from_status ?? 'N/A') }}</span> to <span class="font-medium text-gray-900">{{ ucfirst($history->to_status) }}</span> by <span class="font-medium text-gray-900">{{ $history->user->name }}</span></p>
                                            @if($history->note)
                                                <p class="mt-1 text-sm text-gray-400 italic">"{{ $history->note }}"</p>
                                            @endif
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            <time datetime="{{ $history->created_at }}">{{ $history->created_at->format('M d, Y H:i') }}</time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500">No history recorded yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
