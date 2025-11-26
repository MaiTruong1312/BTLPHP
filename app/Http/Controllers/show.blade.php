@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <article>
        <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
        
        <p class="text-md text-gray-500 mb-8">
            Posted by <span class="font-semibold">{{ $post->user->name }}</span> on {{ $post->published_at->format('F d, Y') }}
        </p>

        {{-- You can add a featured image here later --}}

        <div class="prose lg:prose-xl max-w-none">
            {!! $post->content !!}
        </div>
    </article>
</div>
@endsection
