@extends('layouts.app')

@section('title', 'My Interviews')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">📅 My Interviews</h1>
            <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">← Back to Dashboard</a>
        </div>

        @if($interviews->count() > 0)
            <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100">
                <ul class="divide-y divide-gray-200">
                    @foreach($interviews as $interview)
                        <li class="p-6 hover:bg-gray-50 transition duration-150 ease-in-out">
                            <div class="flex flex-col md:flex-row justify-between md:items-center space-y-4 md:space-y-0">
                                {{-- Job & Company Info --}}
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3">
                                        <h3 class="text-lg font-bold text-gray-900">
                                            <a href="{{ route('jobs.show', $interview->jobApplication->job->slug) }}" class="hover:underline text-indigo-600">
                                                {{ $interview->jobApplication->job->title }}
                                            </a>
                                        </h3>
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $interview->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $interview->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $interview->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($interview->status) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">
                                        at <span class="font-semibold">{{ $interview->jobApplication->job->employerProfile->company_name ?? 'Company' }}</span>
                                    </p>
                                </div>

                                {{-- Date & Time --}}
                                <div class="flex-1 md:text-center">
                                    <div class="flex items-center md:justify-center text-gray-700">
                                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="font-medium">{{ $interview->scheduled_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center md:justify-center text-gray-500 text-sm mt-1">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $interview->scheduled_at->format('H:i') }} ({{ $interview->duration_minutes }} mins)
                                    </div>
                                </div>

                                {{-- Location & Type --}}
                                <div class="flex-1 md:text-right">
                                    <div class="flex items-center md:justify-end text-gray-700 mb-1">
                                        @if($interview->type === 'online')
                                            <span class="flex items-center text-indigo-600 font-medium">
                                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                </svg>
                                                Online Interview
                                            </span>
                                        @else
                                            <span class="flex items-center text-gray-700 font-medium">
                                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                In-Person
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500 break-words max-w-xs ml-auto">
                                        @if($interview->type === 'online')
                                            <a href="{{ $interview->location }}" target="_blank" class="text-blue-600 hover:underline truncate block">
                                                {{ $interview->location }}
                                            </a>
                                        @else
                                            {{ $interview->location }}
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Notes / Cancellation Reason --}}
                            @if($interview->status === 'cancelled' && $interview->cancellation_reason)
                                <div class="mt-4 bg-red-50 p-3 rounded-md border border-red-100">
                                    <p class="text-sm text-red-700"><strong>Cancellation Reason:</strong> {{ $interview->cancellation_reason }}</p>
                                </div>
                            @elseif($interview->notes)
                                <div class="mt-4 bg-yellow-50 p-3 rounded-md border border-yellow-100">
                                    <p class="text-sm text-yellow-800"><strong>Note from Employer:</strong> {{ $interview->notes }}</p>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="mt-6">
                {{ $interviews->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-2xl shadow-sm border border-gray-100">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No interviews scheduled</h3>
                <p class="mt-1 text-sm text-gray-500">You haven't been invited to any interviews yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection