@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('profile.show') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Update Profile</a>
            @if(auth()->user()->candidateProfile)
            <a href="{{ route('profile.public.show', auth()->user()->id) }}" target="_blank" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700">View Public Profile</a>
            @endif
            <a href="{{ route('home') }}" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Browse Jobs</a>
            <a href="{{ route('applications.index') }}" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">View Applications</a>
        </div>
    </div>
    
    <h1 class="text-3xl font-bold mb-6">Candidate Dashboard</h1>

    <!-- Application Statistics Chart -->
    @if(array_sum($chartData) > 0)
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Application Statistics</h2>
        <canvas id="applicationStatusChart" height="100"></canvas>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Recent Applications</h2>
            @if($applications->count() > 0)
                <div class="space-y-4">
                    @foreach($applications as $application)
                        <div class="border-b pb-4">
                            <h3 class="font-semibold"><a href="{{ route('jobs.show', $application->job->slug) }}" class="text-blue-600 hover:underline">{{ $application->job->title }}</a></h3>
                            <p class="text-sm text-gray-600">Status: <span class="font-semibold">{{ ucfirst($application->status) }}</span></p>
                            <p class="text-sm text-gray-500">Applied: {{ \Carbon\Carbon::parse($application->created_at)->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('applications.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">View all applications →</a>
            @else
                <p class="text-gray-500">No applications yet. <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Browse jobs</a></p>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Saved Jobs</h2>
            @if($savedJobs->count() > 0)
                <div class="space-y-4">
                    @foreach($savedJobs as $job)
                        <div class="border-b pb-4">
                            <h3 class="font-semibold"><a href="{{ route('jobs.show', $job->slug) }}" class="text-blue-600 hover:underline">{{ $job->title }}</a></h3>
                            <p class="text-sm text-gray-500 mb-4">Saved: {{ \Carbon\Carbon::parse($job->pivot->saved_at)->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('saved-jobs.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">View all saved jobs →</a>
            @else
                <p class="text-gray-500">No saved jobs yet.</p>
            @endif
        </div>
    </div>

    <!-- Suggested Jobs -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Suggested Jobs For You</h2>
        @if($suggestedJobs->count() > 0)
            <div class="space-y-4">
                @foreach($suggestedJobs as $job)
                    <div class="border-b pb-4">
                        <h3 class="font-semibold"><a href="{{ route('jobs.show', $job->slug) }}" class="text-blue-600 hover:underline">{{ $job->title }}</a></h3>
                        <p class="text-sm text-gray-600">{{ $job->employerProfile->company_name }} - {{ $job->location->city }}</p>
                        <p class="text-sm text-gray-500 mt-1">Matching skills will make you a strong candidate.</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No job suggestions at the moment.
                <a href="{{ route('profile.show') }}" class="text-blue-600 hover:underline">Add skills to your profile</a> to get personalized recommendations.
            </p>
        @endif
    </div>

    
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chartData = @json($chartData ?? []);
        
        // Chỉ hiển thị biểu đồ nếu có dữ liệu
        if (chartData.reduce((a, b) => a + b, 0) > 0) {
            const ctx = document.getElementById('applicationStatusChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar', // Bạn có thể đổi thành 'pie', 'doughnut', 'line'
                data: {
                    labels: @json($chartLabels ?? []),
                    datasets: [{
                        label: 'Number of Applications',
                        data: chartData,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(201, 203, 207, 0.6)'
                        ],
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                }
            });
        }
    });
</script>
@endpush
