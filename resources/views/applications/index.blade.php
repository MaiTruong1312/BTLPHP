@extends('layouts.app')

@section('title', 'My Applications')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-6">My Applications</h1>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-4">
            <form action="{{ route('applications.index') }}" method="GET" class="flex gap-4">
                <select name="status" class="px-4 py-2 border rounded-lg">
                    <option value="">All Statuses</option>
                    <option value="applied" {{ request('status') == 'applied' ? 'selected' : '' }}>Applied</option>
                    <option value="reviewing" {{ request('status') == 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                    <option value="interview" {{ request('status') == 'interview' ? 'selected' : '' }}>Interview</option>
                    <option value="offered" {{ request('status') == 'offered' ? 'selected' : '' }}>Offered</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Filter</button>
            </form>
        </div>

        @if($applications->count() > 0)
            <div class="space-y-4">
                @foreach($applications as $application)
                    <div class="border rounded-lg p-6 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold mb-2">
                                    <a href="{{ route('jobs.show', $application->job->slug) }}" class="text-blue-600 hover:underline">{{ $application->job->title }}</a>
                                </h3>
                                <p class="text-gray-600 mb-2">{{ $application->job->employerProfile->company_name ?? 'Company' }}</p>
                                <div class="flex gap-2 mb-2">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ $application->job->category->name }}</span>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full">{{ $application->job->location->city }}</span>
                                    <span class="px-3 py-1 {{ $application->status == 'offered' ? 'bg-green-100 text-green-800' : ($application->status == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }} text-xs rounded-full">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500">Applied: {{ $application->applied_at->format('F d, Y') }}</p>
                            </div>
                            <div>
                                <a href="{{ route('applications.show', $application) }}" class="text-blue-600 hover:underline">View Details →</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $applications->links() }}
            </div>
        @else
            <p class="text-gray-500 text-center py-12">No applications found. <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Browse jobs</a></p>
        @endif
    </div>
</div>
@endsection

