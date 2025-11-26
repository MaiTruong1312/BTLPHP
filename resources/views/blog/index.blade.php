@extends('layouts.app')

@section('title', 'Our Blog')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-4xl font-bold text-center mb-10">Company Blog</h1>

    <div class="space-y-12">
        @forelse($posts as $post)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                {{-- You can add a featured image here later --}}
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-2xl font-semibold mb-2">
                                <a href="{{ route('blog.show', $post->slug) }}" class="text-gray-800 hover:text-blue-600">{{ $post->title }}</a>
                            </h2>
                            <p class="text-sm text-gray-500 mb-4">
                                Posted by {{ $post->user->name }} on {{ $post->published_at->format('F d, Y') }}
                            </p>
                        </div>
                        <div class="flex space-x-2">
                            @can('update', $post)
                                <a href="{{ route('blog.edit', $post) }}" class="text-sm text-blue-600 hover:underline">Edit</a>
                            @endcan
                            @can('delete', $post)
                                <form action="{{ route('blog.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:underline">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                    <div class="text-gray-600">
                        {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 200) }}
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500">No blog posts have been published yet.</p>
        @endforelse

        <div class="mt-8">{{ $posts->links() }}</div>
    </div>
</div>
@endsection

