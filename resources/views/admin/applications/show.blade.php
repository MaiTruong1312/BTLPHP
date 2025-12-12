@extends('layouts.admin')
@php
    use Carbon\Carbon;
@endphp
@section('title', 'Application Detail')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    {{-- Back --}}
    <div class="mt-4 mb-6">
        <a href="{{ route('admin.applications.index') }}" class="text-blue-600 hover:underline">
            ← Back to Applications
        </a>
    </div>

    {{-- Overview --}}
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h1 class="text-2xl font-bold mb-4">Application Overview</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
            {{-- Job --}}
            <div>
                <h2 class="font-semibold text-gray-700 mb-2">Job</h2>
                <p class="text-gray-900">{{ $application->job->title }}</p>
                <p class="text-gray-500">
                    {{ $application->job->category->name ?? 'N/A' }}
                    ·
                    {{ $application->job->location->city ?? 'N/A' }}
                </p>
                <p class="text-gray-500 mt-1">
                    Company:
                    {{ $application->job->employerProfile->company_name ?? 'N/A' }}
                </p>
            </div>

            {{-- Candidate --}}
            <div>
                <h2 class="font-semibold text-gray-700 mb-2">Candidate</h2>
                <p class="text-gray-900">{{ $application->user->name }}</p>
                <p class="text-gray-500">{{ $application->user->email }}</p>
            </div>

            {{-- Status --}}
            <div>
                <h2 class="font-semibold text-gray-700 mb-2">Status</h2>
                <p class="inline-block px-3 py-1 rounded-full bg-gray-100 text-gray-800">
                    {{ ucfirst($application->status) }}
                </p>
                <p class="text-gray-500 mt-2">
                    Applied at:
                    {{ $application->applied_at?->format('M d, Y g:i A') ?? 'N/A' }}
                </p>
            </div>

            {{-- Cover letter --}}
            <div>
                <h2 class="font-semibold text-gray-700 mb-2">Cover Letter</h2>
                <p class="text-gray-700 whitespace-pre-line">
                    {{ $application->cover_letter ?? '—' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Timeline / Logs --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Timeline / Logs</h2>

        @if($logs->isEmpty())
            <p class="text-gray-500">No logs yet.</p>
        @else
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">
                            Time
                        </th>
                        <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">
                            Event
                        </th>
                        <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">
                            Details
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($logs as $log)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $log->time
                            ? Carbon::parse($log->time, 'UTC')   // giả sử DB lưu UTC
                                ->timezone(config('app.timezone')) // đổi sang Asia/Ho_Chi_Minh
                                ->format('M d, Y g:i A')
                            : '' }}
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-gray-900">
                                {{ $log->event }}
                            </td>
                            <td class="px-4 py-2 text-gray-700">
                                {{ $log->details }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
