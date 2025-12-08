@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-10 fade-in">

    <div class="max-w-md w-full px-6">

        <!-- LOGIN FORM -->
        <div class="bg-white/70 glass p-10 rounded-2xl shadow-xl border border-white/40
                    backdrop-blur-xl fade-in-visible">

            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Login</h2>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                {{-- EMAIL --}}
                <div>
                    <label for="email" class="block text-gray-700 text-sm font-semibold mb-1">Email Address</label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email') }}" required autocomplete="email" autofocus
                           class="w-full px-4 py-3 rounded-xl border border-gray-300
                                  focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                  shadow-sm transition @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- PASSWORD --}}
                <div>
                    <label for="password" class="block text-gray-700 text-sm font-semibold mb-1">Password</label>
                    <input type="password" name="password" id="password" required autocomplete="current-password"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300
                                  focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                  shadow-sm transition @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- REMEMBER ME & FORGOT PASSWORD --}}
                <div class="flex items-center justify-between">
                    <div class="flex items-start">
                        <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded mt-0.5">
                        <div class="ml-3 text-sm">
                            <label for="remember" class="text-gray-700">Remember Me</label>
                        </div>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline font-medium">
                            Forgot Your Password?
                        </a>
                    @endif
                </div>

                {{-- SUBMIT --}}
                <button type="submit"
                        class="w-full py-3 bg-indigo-600 text-white rounded-xl font-semibold
                               hover:bg-indigo-700 hover:shadow-xl transform hover:-translate-y-0.5
                               transition-all duration-200">
                    Login
                </button>

                {{-- REGISTER LINK --}}
                <p class="text-center text-gray-600 text-sm">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:underline font-medium">
                        Register here
                    </a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
