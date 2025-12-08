@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-10 fade-in">
    <div class="max-w-md w-full px-6">
        <div class="bg-white/70 glass p-10 rounded-2xl shadow-xl border border-white/40 backdrop-blur-xl">

            <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">
                Forgot Password
            </h2>

            <p class="text-center text-gray-600 text-sm mb-6">
                Enter your email address and we will send you a link to reset your password.
            </p>

            @if (session('status'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-gray-700 text-sm font-semibold mb-1">
                        Email Address
                    </label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-3 rounded-xl border border-gray-300
                                  focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                  shadow-sm transition @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full py-3 bg-indigo-600 text-white rounded-xl font-semibold
                               hover:bg-indigo-700 hover:shadow-xl transform hover:-translate-y-0.5
                               transition-all duration-200">
                    Send reset link
                </button>

                <p class="text-center text-gray-600 text-sm">
                    Remembered your password?
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-medium">
                        Back to login
                    </a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
