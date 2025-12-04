@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Admin Dashboard</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm font-medium">Total Users</h3>
            <p class="text-3xl font-semibold text-gray-800">{{ $stats['total_users'] }}</p>
            <p class="text-gray-500 text-xs mt-2">{{ $stats['new_users_last_week'] }} new this week</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm font-medium">Admins</h3>
            <p class="text-3xl font-semibold text-gray-800">{{ $stats['total_admins'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm font-medium">Employers</h3>
            <p class="text-3xl font-semibold text-gray-800">{{ $stats['total_employers'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm font-medium">Candidates</h3>
            <p class="text-3xl font-semibold text-gray-800">{{ $stats['total_candidates'] ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm font-medium">Total Jobs</h3>
            <p class="text-3xl font-semibold text-gray-800">{{ $stats['total_jobs'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Pending Jobs Column -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow-md rounded-lg">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-xl font-bold text-gray-800">Jobs Pending Approval</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse ($pending_jobs as $job)
                        <div class="p-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <a href="{{ route('jobs.show', $job->slug) }}" class="text-lg font-semibold text-indigo-600 hover:underline">{{ $job->title }}</a>
                                    <p class="text-sm text-gray-600">by {{ $job->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $job->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <!-- Approve Form -->
                                    <form action="{{ route('admin.jobs.update-status', $job->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="published">
                                        <button type="submit" class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full hover:bg-green-600">Approve</button>
                                    </form>
                                    <!-- Reject Form -->
                                    <form action="{{ route('admin.jobs.update-status', $job->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full hover:bg-red-600">Reject</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-6">No jobs are pending approval.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Users Column -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow-md rounded-lg">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-xl font-bold text-gray-800">Recent Users</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse ($recent_users as $user)
                        <div class="p-4 flex items-center">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                            <div class="ml-4">
                                <p class="text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-6">No recent users.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
