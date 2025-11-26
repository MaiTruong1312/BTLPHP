@extends('layouts.app')

@section('title', 'Saved Jobs')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-6">Saved Jobs</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($jobs as $job)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-semibold text-gray-900">
                            <a href="{{ route('jobs.show', $job->slug) }}" class="hover:text-blue-600">{{ $job->title }}</a>
                        </h3>
                        <form action="{{ route('saved-jobs.destroy', $job) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">×</button>
                        </form>
                    </div>
                    <p class="text-gray-600 mb-4">{{ $job->short_description ?? Str::limit($job->description, 100) }}</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ $job->category->name }}</span>
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full">{{ $job->location->city }}</span>
                    </div>
                    <p class="text-sm text-gray-500 mb-4">Saved: {{ \Carbon\Carbon::parse($job->pivot->saved_at)->diffForHumans() }}</p>
                    <a href="{{ route('jobs.show', $job->slug) }}" class="text-blue-600 hover:text-blue-800 font-medium">View Details →</a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No saved jobs yet. <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Browse jobs</a></p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $jobs->links() }}
    </div>
</div>
@endsection
