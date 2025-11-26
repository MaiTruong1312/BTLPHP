@extends('layouts.app')

@section('title', 'Employer Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Employer Dashboard</h1>
        <div class="flex space-x-4">
            <a href="{{ route('blog.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-md">Create Post</a>
            <a href="{{ route('jobs.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Post a New Job</a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Total Jobs Card -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total Jobs Posted</h3>
            <p class="text-3xl font-bold mt-2">{{ $totalJobs }}</p>
        </div>

        <!-- Total Applications Card -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total Applications Received</h3>
            <p class="text-3xl font-bold mt-2">{{ $totalApplications }}</p>
        </div>
    </div>

    <!-- Applications Chart -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Applications Trend</h2>
            <div class="flex space-x-2">
                @php $currentPeriod = $period ?? '30'; @endphp
                <a href="{{ route('dashboard', ['period' => 7]) }}" class="px-3 py-1 text-sm rounded-md {{ $currentPeriod == '7' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">7 Days</a>
                <a href="{{ route('dashboard', ['period' => 30]) }}" class="px-3 py-1 text-sm rounded-md {{ $currentPeriod == '30' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">30 Days</a>
                <a href="{{ route('dashboard', ['period' => 90]) }}" class="px-3 py-1 text-sm rounded-md {{ $currentPeriod == '90' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">90 Days</a>
            </div>
        </div>
        <div class="relative h-80">
            <canvas id="applicationsChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mt-6">
        <h2 class="text-xl font-semibold mb-4">
            Your Posted Jobs <span class="text-gray-500 font-normal">({{ $totalJobs }})</span>
        </h2>
        {{-- The $jobs variable is passed from DashboardController --}}
        @if(isset($jobs) && $jobs->count() > 0)
            <div class="space-y-4">
                @foreach($jobs as $job)
                    <div class="border-b pb-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold"><a href="{{ route('jobs.show', $job->slug) }}" class="text-blue-600 hover:underline">{{ $job->title }}</a></h3>
                                <p class="text-sm text-gray-500">Posted: {{ $job->created_at->diffForHumans() }}</p>
                            </div>
                            <a href="{{ route('jobs.applicants', $job->id) }}" class="text-green-600 hover:underline">View Applications</a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $jobs->links() }}
            </div>
        @else
            <p class="text-gray-500">You have not posted any jobs yet. <a href="{{ route('jobs.create') }}" class="text-blue-600 hover:underline">Post one now!</a></p>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('applicationsChart').getContext('2d');
        const applicationsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Applications',
                    data: @json($chartData),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });
    });
</script>
@endpush