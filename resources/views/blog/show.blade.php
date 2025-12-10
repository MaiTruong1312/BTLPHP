@extends('layouts.app')

@section('title', $title)

@section('content')
<!-- Article Header -->
<div class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 h-96 flex items-center">
        <div class="w-full">
            <!-- Top row: breadcrumb left, date right -->
            <div class="flex items-center justify-between text-indigo-100 mb-6">
                <div class="text-sm">
                    <a href="{{ route('blog.index') }}" class="hover:text-white transition-colors font-medium">Blog</a>
                    <span class="mx-2">/</span>
                    <span class="text-indigo-100 opacity-90">Articles</span>
                </div>

                <div class="text-sm flex items-center space-x-2">
                    <svg class="h-4 w-4 text-indigo-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <time class="font-medium">{{ $date }}</time>
                </div>
            </div>

            <!-- Title centered -->
            <div class="text-center">
                <h1 class="text-5xl font-extrabold leading-tight text-white">{{ $title }}</h1>
                <p class="mt-3 text-indigo-100 opacity-90">By <span class="font-semibold">{{ $author }}</span></p>
            </div>
        </div>
    </div>
</div>

<!-- Article Content -->
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Article Body -->
    <!-- Article Body -->
    <article class="prose prose-lg max-w-none mb-12">
        {!! $content !!}
    </article>

    <!-- Back to Blog -->
    <div class="mt-12">
        <a href="{{ route('blog.index') }}" class="inline-flex items-center px-6 py-3 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition-colors">
            Back to Blog
            <svg class="h-5 w-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
</div>
@endsection

