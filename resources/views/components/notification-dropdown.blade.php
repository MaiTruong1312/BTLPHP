<!-- resources/views/components/notifications-dropdown.blade.php -->
@auth
<div x-data="{ open: false }" class="relative">
    <!-- Nút chuông thông báo -->
    <button @click="open = !open" class="relative text-gray-500 hover:text-gray-700 focus:outline-none">
        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if($unreadNotificationsCount > 0)
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                {{ $unreadNotificationsCount }}
            </span>
        @endif
    </button>

    <!-- Dropdown -->
    <div x-show="open" @click.away="open = false" x-cloak
         class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg overflow-hidden z-20">
        <div class="py-2">
            <div class="flex items-center justify-between px-4 py-2 border-b">
                <h4 class="text-lg font-semibold">Notifications</h4>
                {{-- <a href="#" class="text-sm text-blue-600 hover:underline">Mark all as read</a> --}}
            </div>
            @forelse($unreadNotifications as $notification)
                <a href="{{ route('notifications.markAsRead', $notification) }}"
                   class="flex items-center px-4 py-3 border-b hover:bg-gray-100 -mx-2">
                    <div class="flex-shrink-0">
                        {{-- Có thể thêm icon dựa trên loại thông báo --}}
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-gray-600 text-sm mx-2">
                        {!! $notification->data['message'] !!}
                        <span class="font-light text-xs text-gray-500 block">{{ $notification->created_at->diffForHumans() }}</span>
                    </p>
                </a>
            @empty
                <p class="text-center text-gray-500 py-4">No new notifications.</p>
            @endforelse
            <a href="{{ route('notifications.index') }}" class="block bg-gray-800 text-white text-center font-bold py-2">See all notifications</a>
        </div>
    </div>
</div>
@endauth
