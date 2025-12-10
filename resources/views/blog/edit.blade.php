@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 sm:p-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6">{{ __('Edit Post') }}</h1>

            <form method="POST" action="{{ route('blog.update', $post) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Title') }}</label>
                    <div class="mt-1">
                        <input id="title" type="text" name="title" value="{{ old('title', $post->title) }}" required autocomplete="title" autofocus
                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('title') border-red-500 @enderror">
                    </div>
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">{{ __('Content') }}</label>
                    <div class="mt-1">
                        <textarea id="content" name="content" required rows="12"
                                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('content') border-red-500 @enderror">{{ old('content', $post->content) }}</textarea>
                    </div>
                    @error('content')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Image -->
                @if($post->image)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="h-48 rounded-lg shadow-md">
                    </div>
                @endif

                <!-- Image Upload -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">{{ __('Replace Image (Optional)') }}</label>
                    <div class="mt-1">
                        <input id="image" type="file" name="image"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('image') border-red-500 @enderror">
                    </div>
                    <p class="mt-1 text-sm text-gray-500">PNG, JPG, GIF up to 2MB</p>
                    @error('image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                        <select id="status" name="status" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md @error('status') border-red-500 @enderror">
                            <option value="draft" @if(old('status', $post->status) == 'draft') selected @endif>{{ __('Draft') }}</option>
                            <option value="published" @if(old('status', $post->status) == 'published') selected @endif>{{ __('Published') }}</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Published At -->
                    <div>
                        <label for="published_at" class="block text-sm font-medium text-gray-700">{{ __('Published At (Optional)') }}</label>
                        <input id="published_at" type="datetime-local" name="published_at" value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('published_at') border-red-500 @enderror">
                        @error('published_at')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-between pt-4">
                    <a href="{{ route('blog.show', $post) }}" class="inline-flex justify-center py-2 px-6 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">
                        {{ __('Update Post') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
