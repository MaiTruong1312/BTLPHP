<!-- resources/views/jobs/_reply.blade.php -->
<div x-data="{ 
        openEdit: false,
        isLiked: {{ $reply->is_liked ? 'true' : 'false' }},
        likesCount: {{ $reply->likes_count ?? 0 }},
     }" 
     class="flex space-x-4">
    <img src="{{ $reply->user->avatar ? asset('storage/' . $reply->user->avatar) : asset('images/default-avatar.png') }}" alt="{{ $reply->user->name }}" class="w-10 h-10 rounded-full">
    <div class="flex-1">
        <div class="flex items-center justify-between">
            <p class="font-semibold">{{ $reply->user->name }}</p>
            <span class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
        </div>

        <!-- Reply Content -->
        <div x-show="!openEdit" class="text-gray-700 mt-1">
            <p>{{ $reply->content }}</p>
        </div>

        <!-- Edit Form (hidden by default) -->
        @can('update', $reply)
            <div x-show="openEdit" x-cloak class="mt-2">
                <form action="{{ route('comments.update', $reply) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <textarea name="content" rows="2" class="w-full border-gray-300 rounded-md shadow-sm text-sm" required>{{ $reply->content }}</textarea>
                    <div class="mt-2">
                        <button type="submit" class="bg-blue-500 text-white px-3 py-1 text-xs rounded-md">Save</button>
                        <button @click="openEdit = false" type="button" class="text-xs text-gray-600 ml-2">Cancel</button>
                    </div>
                </form>
            </div>
        @endcan

        <!-- Action Buttons: Like, Edit, Delete -->
        <div class="mt-2 flex items-center space-x-4 text-xs">
            @auth
                <!-- Like Button -->
                <button @click="
                    fetch('{{ route('comments.like', $reply) }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                    })
                    .then(res => res.json())
                    .then(data => {
                        isLiked = data.liked;
                        likesCount = data.likes_count;
                    });
                " :class="{ 'text-blue-600 font-bold': isLiked, 'text-gray-500': !isLiked }" class="hover:underline font-semibold flex items-center space-x-1">
                    <span x-text="isLiked ? 'Liked' : 'Like'"></span>
                </button>
            @endauth

            @can('update', $reply)
                <button @click="openEdit = !openEdit" type="button" class="text-gray-500 hover:underline font-semibold">Edit</button>
            @endcan

            @can('delete', $reply)
                <form action="{{ route('comments.destroy', $reply) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this reply?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs text-red-600 hover:underline font-semibold">Delete</button>
                </form>
            @endcan
            
            <!-- Likes Count -->
            <div x-show="likesCount > 0" class="flex items-center text-gray-500" x-cloak>
                <svg class="w-4 h-4 mr-1 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.562 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path></svg>
                <span x-text="likesCount"></span>
            </div>
        </div>
    </div>
</div>
