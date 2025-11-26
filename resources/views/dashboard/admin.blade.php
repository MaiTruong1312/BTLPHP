@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Admin Dashboard</h1>
        <a href="{{ route('blog.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">Create Post</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-600 mb-2">Total Jobs</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $totalJobs }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-600 mb-2">Total Applications</h3>
            <p class="text-3xl font-bold text-green-600">{{ $totalApplications }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-600 mb-2">Total Users</h3>
            <p class="text-3xl font-bold text-purple-600">{{ $totalUsers }}</p>
        </div>
    </div>
</div>
@endsection

