@extends('layouts.app')

@section('title', 'All Jobs')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-6">All Jobs</h1>
    
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form action="{{ route('jobs.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search jobs..." class="px-4 py-2 border rounded-lg md:col-span-2">
            <select name="category" class="px-4 py-2 border rounded-lg">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <select name="location" class="px-4 py-2 border rounded-lg">
                <option value="">All Locations</option>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}" {{ request('location') == $location->id ? 'selected' : '' }}>{{ $location->city }}</option>
                @endforeach
            </select>
            <input type="number" name="min_salary" value="{{ request('min_salary') }}" placeholder="Min Salary" class="px-4 py-2 border rounded-lg">
            <input type="number" name="max_salary" value="{{ request('max_salary') }}" placeholder="Max Salary" class="px-4 py-2 border rounded-lg">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 md:col-span-2">Search</button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($jobs as $job)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        <a href="{{ route('jobs.show', $job->slug) }}" class="hover:text-blue-600">{{ $job->title }}</a>
                    </h3>
                    <p class="text-gray-600 mb-4">{{ $job->short_description ?? Str::limit($job->description, 100) }}</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ $job->category->name }}</span>
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full">{{ $job->location->city }}</span>
                    </div>
                    <a href="{{ route('jobs.show', $job->slug) }}" class="text-blue-600 hover:text-blue-800 font-medium">View Details →</a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No jobs found.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $jobs->links() }}
    </div>
</div>
@endsection

