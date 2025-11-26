@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-8 mb-8 text-white">
        <h1 class="text-4xl font-bold mb-4">Find Your Dream Job</h1>
        <p class="text-xl mb-6">Discover thousands of job opportunities from top companies</p>
        <form action="{{ route('home') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search jobs..." class="flex-1 px-4 py-3 rounded-lg text-gray-900">
            <select name="category" class="px-4 py-3 rounded-lg text-gray-900">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <select name="location" class="px-4 py-3 rounded-lg text-gray-900">
                <option value="">All Locations</option>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}" {{ request('location') == $location->id ? 'selected' : '' }}>{{ $location->city }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">Search</button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($jobs as $job)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-semibold text-gray-900">
                            <a href="{{ route('jobs.show', $job->slug) }}" class="hover:text-blue-600">{{ $job->title }}</a>
                        </h3>
                    </div>
                    <p class="text-gray-600 mb-4">{{ $job->short_description ?? Str::limit($job->description, 100) }}</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ $job->category->name }}</span>
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full">{{ $job->location->city }}</span>
                        <span class="px-3 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">{{ ucfirst(str_replace('_', ' ', $job->job_type)) }}</span>
                    </div>
                    @if($job->salary_min || $job->salary_max)
                        <p class="text-gray-700 font-semibold mb-4">
                            @if($job->salary_min && $job->salary_max)
                                {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} {{ $job->currency }}/{{ $job->salary_type }}
                            @elseif($job->salary_min)
                                From {{ number_format($job->salary_min) }} {{ $job->currency }}/{{ $job->salary_type }}
                            @else
                                Negotiable
                            @endif
                        </p>
                    @endif
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">{{ $job->created_at->diffForHumans() }}</span>
                        <a href="{{ route('jobs.show', $job->slug) }}" class="text-blue-600 hover:text-blue-800 font-medium">View Details →</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No jobs found. Try adjusting your search criteria.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $jobs->links() }}
    </div>
</div>
@endsection

