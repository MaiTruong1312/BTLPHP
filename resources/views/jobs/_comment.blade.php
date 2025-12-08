<!-- resources/views/jobs/_comment.blade.php -->
<div x-data="{ 
        openReply: false, 
        openEdit: false,
        isLiked: {{ $comment->is_liked ? 'true' : 'false' }},
        likesCount: {{ $comment->likes_count }},
     }" 
     class="flex space-x-4 py-4 @if(!$loop->last) border-b @endif">
    <img src="{{ $comment->user->avatar ? asset('storage/' . $comment->user->avatar) : asset('images/default-avatar.png') }}" alt="{{ $comment->user->name }}" class="w-10 h-10 rounded-full">
    <div class="flex-1">
        <div class="flex items-center justify-between">
            <p class="font-semibold">{{ $comment->user->name }}</p>
            <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
        </div>

        <!-- Hiển thị nội dung bình luận hoặc form chỉnh sửa -->
        <div x-show="!openEdit" class="text-gray-700 mt-1">
            <p>{{ $comment->content }}</p>
        </div>

        <!-- Form Chỉnh sửa (ẩn mặc định) -->
        @can('update', $comment)
            <div x-show="openEdit" x-cloak class="mt-2">
                <form action="{{ route('comments.update', $comment) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <textarea name="content" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" required>{{ $comment->content }}</textarea>
                    <div class="mt-2">
                        <button type="submit" class="bg-blue-500 text-white px-3 py-1 text-xs rounded-md hover:bg-blue-600">Lưu</button>
                        <button @click="openEdit = false" type="button" class="text-xs text-gray-600 ml-2">Hủy</button>
                    </div>
                </form>
            </div>
        @endcan

        <!-- Các nút hành động: Trả lời, Sửa, Xóa -->
        <div class="mt-2 flex items-center space-x-4 text-xs">
            @auth
                <!-- Nút Thích -->
                <button @click="
                    fetch('{{ route('comments.like', $comment) }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                    })
                    .then(res => res.json())
                    .then(data => {
                        isLiked = data.liked;
                        likesCount = data.likes_count;
                    });
                " :class="{ 'text-blue-600 font-bold': isLiked, 'text-gray-500': !isLiked }" class="hover:underline font-semibold flex items-center space-x-1">
                    <span x-text="isLiked ? 'Đã thích' : 'Thích'"></span>
                </button>

                <!-- Nút Trả lời -->
                <button @click="openReply = !openReply" type="button" class="text-gray-500 hover:underline font-semibold">
                    Trả lời
                </button>
            @endauth

            @can('update', $comment)
                <button @click="openEdit = !openEdit" type="button" class="text-gray-500 hover:underline font-semibold">Sửa</button>
            @endcan

            @can('delete', $comment)
                <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này không?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs text-red-600 hover:underline font-semibold">Xóa</button>
                </form>
            @endcan

            <!-- Hiển thị số lượt thích -->
            <div x-show="likesCount > 0" class="flex items-center text-gray-500" x-cloak>
                <svg class="w-4 h-4 mr-1 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.562 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path></svg>
                <span x-text="likesCount"></span>
            </div>
        </div>

        <!-- Form Trả lời (ẩn mặc định) -->
        <div x-show="openReply" x-cloak class="mt-3 ml-4">
            <form action="{{ route('comments.store', $job) }}" method="POST">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <textarea name="content" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm" placeholder="Viết câu trả lời của bạn..." required></textarea>
                <div class="mt-2">
                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 text-xs rounded-md hover:bg-blue-600">Gửi</button>
                    <button @click="openReply = false" type="button" class="text-xs text-gray-600 ml-2">Hủy</button>
                </div>
            </form>
        </div>

        <!-- Hiển thị các bình luận trả lời (con) -->
        @if($comment->replies->isNotEmpty())
            <div class="ml-8 mt-4 space-y-4">
                @foreach($comment->replies as $reply)
                    @include('jobs._reply', ['reply' => $reply])
                @endforeach
            </div>
        @endif
    </div>
</div>
