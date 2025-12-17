@extends('layouts.app')

@section('title', 'Interview Details')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <nav class="text-sm mb-4">
            <a href="{{ route('employer.interviews.index') }}" class="text-indigo-600 hover:text-indigo-800">← Back to Schedule</a>
        </nav>
        <h1 class="text-3xl font-bold text-gray-900">Interview Details</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Candidate & Job Info -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Candidate Info</h2>
                <div class="flex items-center mb-4">
                    <img class="h-12 w-12 rounded-full object-cover mr-4" 
                         src="{{ $interview->jobApplication->user->avatar ? asset('storage/' . $interview->jobApplication->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($interview->jobApplication->user->name) }}" 
                         alt="{{ $interview->jobApplication->user->name }}">
                    <div>
                        <p class="font-medium text-gray-900">{{ $interview->jobApplication->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $interview->jobApplication->user->email }}</p>
                    </div>
                </div>
                <div class="border-t pt-4">
                    <p class="text-sm text-gray-600 mb-1">Applying for:</p>
                    <p class="font-medium text-indigo-600">
                        <a href="{{ route('jobs.show', $interview->jobApplication->job->slug) }}" target="_blank">
                            {{ $interview->jobApplication->job->title }}
                        </a>
                    </p>
                </div>
                <div class="mt-4">
                    <a href="{{ route('employer.applications.show', $interview->jobApplication->id) }}" class="text-sm text-indigo-600 hover:underline">
                        View Full Application & CV
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Column: Edit Interview Form -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Edit Schedule</h2>
                
                <form id="updateInterviewForm" action="{{ route('employer.interviews.update', $interview->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date & Time</label>
                            <input type="datetime-local" name="scheduled_at" required
                                   value="{{ old('scheduled_at', $interview->scheduled_at->format('Y-m-d\TH:i')) }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Duration (Minutes)</label>
                            <input type="number" name="duration_minutes" min="15" step="15" required
                                   value="{{ old('duration_minutes', $interview->duration_minutes) }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                            <select name="type" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="online" {{ $interview->type == 'online' ? 'selected' : '' }}>Online (Meet/Zoom)</option>
                                <option value="offline" {{ $interview->type == 'offline' ? 'selected' : '' }}>Offline (In-person)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status_select" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="scheduled" {{ $interview->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="completed" {{ $interview->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $interview->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <!-- Cancellation Reason Field (Hidden by default) -->
                    <div id="cancellation_field" class="mb-6 {{ $interview->status == 'cancelled' ? '' : 'hidden' }}">
                        <label class="block text-sm font-medium text-red-700 mb-1">Reason for Cancellation <span class="text-red-500">*</span></label>
                        <textarea name="cancellation_reason" rows="3" placeholder="Please explain why the interview is cancelled..."
                                  class="w-full border-red-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 bg-red-50">{{ old('cancellation_reason', $interview->cancellation_reason) }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Location / Meeting Link</label>
                        <input type="text" name="location" required
                               value="{{ old('location', $interview->location) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes (Visible to Candidate)</label>
                        <textarea name="notes" rows="4"
                                  class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('notes', $interview->notes) }}</textarea>
                    </div>

                    <div class="flex justify-between items-center">
                        @if($interview->status !== 'cancelled' && $interview->status !== 'completed')
                            <button type="button" onclick="openCancellationModal()" class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Cancel Interview
                            </button>
                        @else
                            <div></div>
                        @endif
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Candidate Evaluation Card (shown when interview is completed) -->
            @if($interview->status === 'completed')
            <div class="bg-white shadow rounded-lg p-6 mt-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Candidate Evaluation</h2>
                
                <form action="{{ route('employer.interviews.evaluation.store', $interview->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Overall Rating</label>
                        <div class="flex items-center space-x-4">
                            @for ($i = 1; $i <= 5; $i++)
                                <label class="flex items-center space-x-1 cursor-pointer">
                                    <input type="radio" name="rating" value="{{ $i }}" class="form-radio h-5 w-5 text-indigo-600" {{ old('rating', $interview->evaluation->rating ?? 0) == $i ? 'checked' : '' }} required>
                                    <span class="text-gray-700">{{ $i }} ⭐</span>
                                </label>
                            @endfor
                        </div>
                        @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Strengths</label>
                        <textarea name="strengths" rows="3" placeholder="What were the candidate's main strengths?"
                                  class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('strengths', $interview->evaluation->strengths ?? '') }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Weaknesses / Areas for Improvement</label>
                        <textarea name="weaknesses" rows="3" placeholder="Any weaknesses or areas where the candidate could improve?"
                                  class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('weaknesses', $interview->evaluation->weaknesses ?? '') }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Overall Comment <span class="text-red-500">*</span></label>
                        <textarea name="overall_comment" rows="4" required placeholder="Summarize your evaluation and recommendation."
                                  class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('overall_comment', $interview->evaluation->overall_comment ?? '') }}</textarea>
                        @error('overall_comment') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            {{ $interview->evaluation ? 'Update Evaluation' : 'Save Evaluation' }}
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Cancellation Modal -->
<div id="cancellationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Cancel Interview</h3>
            <div class="mt-2 px-2 py-3">
                <p class="text-sm text-gray-500 mb-4">
                    Are you sure you want to cancel this interview? Please provide a reason for the candidate.
                </p>
                <textarea id="modal_cancellation_reason" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" rows="3" placeholder="Reason for cancellation (required)..."></textarea>
                <p id="modal_error" class="text-red-500 text-xs mt-1 hidden text-left">Please enter a reason.</p>
            </div>
            <div class="flex justify-center gap-4 mt-3">
                <button onclick="closeCancellationModal()" class="px-4 py-2 bg-gray-100 text-gray-700 text-base font-medium rounded-md shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Back
                </button>
                <button id="confirmCancelBtn" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                    Confirm Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status_select');
        const cancellationField = document.getElementById('cancellation_field');

        statusSelect.addEventListener('change', function() {
            if (this.value === 'cancelled') {
                cancellationField.classList.remove('hidden');
            } else {
                cancellationField.classList.add('hidden');
            }
        });
    });

    function openCancellationModal() {
        document.getElementById('cancellationModal').classList.remove('hidden');
    }

    function closeCancellationModal() {
        document.getElementById('cancellationModal').classList.add('hidden');
        document.getElementById('modal_error').classList.add('hidden');
    }

    document.getElementById('confirmCancelBtn').addEventListener('click', function() {
        const reason = document.getElementById('modal_cancellation_reason').value;
        if (!reason.trim()) {
            document.getElementById('modal_error').classList.remove('hidden');
            return;
        }

        // Update main form
        const statusSelect = document.getElementById('status_select');
        statusSelect.value = 'cancelled';
        
        const mainReasonField = document.querySelector('textarea[name="cancellation_reason"]');
        mainReasonField.value = reason;

        // Submit form
        document.getElementById('updateInterviewForm').submit();
    });
</script>
@endsection
