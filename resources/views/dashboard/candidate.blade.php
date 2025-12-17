@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="relative bg-gray-50 min-h-screen py-10">

    {{-- Soft Background Glow --}}
    <div class="absolute inset-0 -z-10 opacity-30">
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-blue-200 blur-3xl rounded-full"></div>
        <div class="absolute top-1/3 -right-20 w-64 h-64 bg-indigo-200 blur-3xl rounded-full"></div>
        <div class="absolute bottom-0 left-1/3 w-72 h-72 bg-blue-100 blur-3xl rounded-full"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- PAGE TITLE --}}
        <h1 class="text-4xl font-extrabold text-gray-900 mb-8 tracking-tight">
            👤 Candidate Dashboard
        </h1>

        {{-- QUICK ACTIONS --}}
        <div class="bg-white shadow-lg rounded-2xl p-8 mb-10 border border-gray-100">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">⚡ Quick Actions</h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                <a href="{{ route('profile.show') }}"
                   class="flex items-center justify-center bg-blue-600 text-white py-3 rounded-xl font-semibold shadow hover:bg-blue-700 transition transform hover:-translate-y-1">
                    ✏ Update Profile
                </a>

                {{-- New Interview Button --}}
                <a href="{{ route('candidate.interviews.index') }}"
                   class="flex items-center justify-center bg-indigo-600 text-white py-3 rounded-xl font-semibold shadow hover:bg-indigo-700 transition transform hover:-translate-y-1">
                    📅 My Interviews
                </a>

                @if(auth()->user()->candidateProfile)
                    <a href="{{ route('profile.public.show', auth()->user()->id) }}"
                       target="_blank"
                       class="flex items-center justify-center bg-gray-700 text-white py-3 rounded-xl font-semibold shadow hover:bg-gray-800 transition transform hover:-translate-y-1">
                        🌐 View Public Profile
                    </a>
                @endif

                <a href="{{ route('home') }}"
                   class="flex items-center justify-center bg-green-600 text-white py-3 rounded-xl font-semibold shadow hover:bg-green-700 transition transform hover:-translate-y-1">
                    🔍 Browse Jobs
                </a>

                <a href="{{ route('applications.index') }}"
                   class="flex items-center justify-center bg-purple-600 text-white py-3 rounded-xl font-semibold shadow hover:bg-purple-700 transition transform hover:-translate-y-1">
                    📄 Applications
                </a>
            </div>
        </div>

        {{-- APPLICATION STATISTICS --}}
        @if(array_sum($chartData) > 0)
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-10 border border-gray-100">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">📊 Application Statistics</h2>
                <p class="text-gray-500 mb-6">Your current application status overview.</p>

                <canvas id="applicationStatusChart" height="120"></canvas>
            </div>
        @endif

        {{-- APPLICATION + SAVED JOBS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">

            {{-- RECENT APPLICATIONS --}}
            <div class="bg-white shadow-lg rounded-2xl p-8 border border-gray-100">
                <h2 class="text-xl font-bold mb-4 text-gray-800">🗂 Recent Applications</h2>

                @if($applications->count() > 0)
                    <div class="space-y-5">
                        @foreach($applications as $application)
                            <div class="p-4 border border-gray-200 rounded-xl hover:shadow-md transition bg-gray-50 hover:bg-white">
                                <h3 class="font-semibold text-lg">
                                    <a href="{{ route('jobs.show', $application->job->slug) }}"
                                       class="text-blue-600 hover:underline">
                                        {{ $application->job->title }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    Status:
                                    <span class="font-semibold">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </p>
                                <p class="text-sm text-gray-500">
                                    Applied: {{ \Carbon\Carbon::parse($application->created_at)->diffForHumans() }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <a href="{{ route('applications.index') }}"
                       class="mt-5 inline-block font-medium text-blue-600 hover:underline">
                        View all applications →
                    </a>

                @else
                    <p class="text-gray-500">No applications yet.
                        <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Browse jobs</a>
                    </p>
                @endif
            </div>

            {{-- SAVED JOBS --}}
            <div class="bg-white shadow-lg rounded-2xl p-8 border border-gray-100">
                <h2 class="text-xl font-bold mb-4 text-gray-800">⭐ Saved Jobs</h2>

                @if($savedJobs->count() > 0)
                    <div class="space-y-5">
                        @foreach($savedJobs as $job)
                            <div class="p-4 border border-gray-200 rounded-xl hover:shadow-md transition bg-gray-50 hover:bg-white">
                                <h3 class="font-semibold text-lg">
                                    <a href="{{ route('jobs.show', $job->slug) }}"
                                       class="text-blue-600 hover:underline">
                                        {{ $job->title }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-500">
                                    Saved: {{ \Carbon\Carbon::parse($job->pivot->saved_at)->diffForHumans() }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <a href="{{ route('saved-jobs.index') }}"
                       class="mt-5 inline-block font-medium text-blue-600 hover:underline">
                        View all saved jobs →
                    </a>

                @else
                    <p class="text-gray-500">No saved jobs yet.</p>
                @endif
            </div>

        </div>

        {{-- SUGGESTED JOBS --}}
        <div class="bg-white shadow-lg rounded-2xl p-8 mb-10 border border-gray-100">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">🎯 Suggested Jobs For You</h2>

            @if($suggestedJobs->count() > 0)
                <div class="space-y-6">
                    @foreach($suggestedJobs as $job)
                        <div class="p-5 border border-gray-200 rounded-xl bg-gray-50 hover:shadow-md transition hover:bg-white">
                            <h3 class="font-semibold text-lg">
                                <a href="{{ route('jobs.show', $job->slug) }}"
                                   class="text-blue-600 hover:underline">
                                    {{ $job->title }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $job->employerProfile->company_name }} • {{ $job->location->city }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">🔥 Matching skills: you're a strong candidate.</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No job suggestions yet.
                    <a href="{{ route('profile.show') }}" class="text-blue-600 hover:underline">
                        Add skills to your profile
                    </a>
                    to get better recommendations.
                </p>
            @endif
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const chartData = @json($chartData ?? []);

    if (chartData.reduce((a, b) => a + b, 0) > 0) {
        const ctx = document.getElementById('applicationStatusChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartLabels ?? []),
                datasets: [{
                    label: 'Applications',
                    data: chartData,
                    borderRadius: 8,
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',   // blue
                        'rgba(234, 179, 8, 0.7)',    // yellow
                        'rgba(16, 185, 129, 0.7)',   // green
                        'rgba(168, 85, 247, 0.7)',   // purple
                        'rgba(239, 68, 68, 0.7)',    // red
                        'rgba(107, 114, 128, 0.7)'   // gray
                    ],
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }
});
</script>
@endpush
