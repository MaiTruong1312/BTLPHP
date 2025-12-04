@extends('layouts.app')

@section('title', 'All Notifications')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Notifications</h1>
            @if($notifications->isNotEmpty())
                <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Mark all as read</button>
                </form>
            @endif
        </div>

        <div class="divide-y divide-gray-200">
            @forelse($notifications as $notification)
                <div class="p-6 {{ $notification->read() ? 'bg-gray-50' : 'bg-white' }}">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            @if($notification->read())
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @else
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @endif
                        </div>
                        <div class="ml-4 flex-grow">
                            <div class="flex justify-between items-center">
                                <a href="{{ $notification->data['url'] ?? '#' }}" class="text-sm text-gray-600 hover:text-gray-900">
                                    {!! $notification->data['message'] !!}
                                </a>
                                @if(!$notification->read())
                                <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs font-semibold text-blue-600 hover:text-blue-800" title="Mark as read">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">
                    You have no notifications.
                </div>
            @endforelse
        </div>
        
        @if($notifications->hasPages())
            <div class="bg-gray-50 px-6 py-4">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
