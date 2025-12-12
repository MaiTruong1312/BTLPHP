@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-10 fade-in">
    <div class="max-w-md w-full px-6">
        <div class="bg-white/70 glass p-10 rounded-2xl shadow-xl border border-white/40 backdrop-blur-xl">

            <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">
                Reset Password
            </h2>

            @if (session('status'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ request('email', $email) }}">

                <div>
                    <label for="password" class="block text-gray-700 text-sm font-semibold mb-1">
                        New Password
                    </label>
                    <input id="password" type="password" name="password" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-300
                                  focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                  shadow-sm transition @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-semibold mb-1">
                        Confirm Password
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-300
                                  focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                  shadow-sm transition">
                </div>

                <button type="submit"
                        class="w-full py-3 bg-indigo-600 text-white rounded-xl font-semibold
                               hover:bg-indigo-700 hover:shadow-xl transform hover:-translate-y-0.5
                               transition-all duration-200">
                    Change password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
