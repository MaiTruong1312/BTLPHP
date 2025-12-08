@extends('layouts.admin')

@section('title', 'Manage Applications')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">Job Applications</h1>
            <p class="text-gray-600">Monitor and moderate all applications</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow mb-6">
        <form method="GET" class="p-6 grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search job or candidate" class="border rounded-lg px-4 py-2 md:col-span-2">
            <select name="status" class="border rounded-lg px-4 py-2">
                <option value="">All Statuses</option>
                @foreach(['applied','reviewing','interview','offered','rejected','withdrawn'] as $status)
                    <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-600 text-white rounded-lg px-4 py-2 font-semibold hover:bg-blue-700">Filter</button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidate</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied On</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($applications as $application)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">{{ $application->job->title }}</div>
                            <div class="text-sm text-gray-500">{{ $application->job->employerProfile->company_name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">{{ $application->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $application->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form method="POST" action="{{ route('admin.applications.update-status', $application) }}">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="border rounded px-2 py-1 text-sm" onchange="this.form.submit()">
                                    @foreach(['applied','reviewing','interview','offered','rejected','withdrawn'] as $status)
                                        <option value="{{ $status }}" {{ $application->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $application->applied_at?->format('M d, Y g:i A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('jobs.show', $application->job->slug) }}" class="text-blue-600 hover:text-blue-900 mr-3" target="_blank">View Job</a>
                            <form action="{{ route('admin.applications.destroy', $application) }}" method="POST" class="inline" onsubmit="return confirm('Delete this application?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No applications found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $applications->links() }}
    </div>
</div>
@endsection
