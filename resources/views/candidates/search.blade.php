@extends('layouts.app')

@section('title', 'Search Candidates')

@section('content')
<div class="bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl">
                Find Your Next Great Hire
            </h1>
            <p class="mt-4 text-xl text-gray-600">
                Access our database of talented candidates.
            </p>
        </div>

        <!-- Search Form -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <form action="{{ route('candidates.search') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="keyword" class="block text-sm font-medium text-gray-700">Keyword</label>
                        <input type="text" name="keyword" id="keyword" value="{{ request('keyword') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., PHP Developer, Manager...">
                    </div>
                    <div>
                        <label for="skills" class="block text-sm font-medium text-gray-700">Skills</label>
                        <select name="skills[]" id="skills" multiple class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach($skills as $skill)
                                <option value="{{ $skill->id }}" {{ in_array($skill->id, request('skills', [])) ? 'selected' : '' }}>
                                    {{ $skill->name }}
                                </option>
                            @endforeach
                        </select>
                         <p class="text-xs text-gray-500 mt-1">Hold Ctrl or Cmd to select multiple.</p>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-gray-800 text-white py-2 px-4 rounded-md hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Search
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Search Results -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($candidates as $candidate)
                <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col">
                    <div class="flex items-center mb-4">
                        <img class="h-16 w-16 rounded-full object-cover mr-4" src="{{ $candidate->user->avatar ? asset('storage/' . $candidate->user->avatar) : asset('images/default-avatar.png') }}" alt="{{ $candidate->user->name }}">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">
                                <a href="{{ route('profile.public.show', $candidate->user->id) }}" class="hover:text-purple-600">{{ $candidate->user->name }}</a>
                            </h2>
                            <p class="text-sm text-gray-600">{{ $candidate->experiences->first()->position ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm mb-4 flex-grow">{{ Str::limit($candidate->summary, 120) }}</p>
                    <div class="mb-4">
                        <h3 class="text-sm font-semibold text-gray-800 mb-2">Skills</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($candidate->skills->take(5) as $skill)
                                <span class="bg-gray-200 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ $skill->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-auto">
                        <a href="{{ route('profile.public.show', $candidate->user_id) }}" class="w-full block text-center bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-purple-700">
                            View Profile
                        </a>
                    </div>
                </div>
            @empty
                <div class="md:col-span-2 lg:col-span-3 text-center py-12">
                    <p class="text-gray-600 text-lg">No candidates found matching your criteria.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $candidates->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
