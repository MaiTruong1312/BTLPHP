@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="min-h-[75vh] flex items-center justify-center py-10 fade-in">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-5xl w-full px-6">

        <!-- LEFT BANNER -->
        <div class="hidden md:flex flex-col justify-center items-center text-center space-y-6">

            <img src="{{ asset('images/job_banner1.png') }}"
                 alt="Work Illustration"
                 class="w-full max-w-sm rounded-2xl shadow-xl border border-white/30 object-cover">

            <h2 class="text-3xl font-extrabold text-gray-800">
                Welcome back to <span class="text-indigo-600">JobPortal</span> 👋
            </h2>

            <p class="text-gray-600 leading-relaxed max-w-sm">
                Đăng nhập để tiếp tục hành trình tìm việc –  
                kết nối nhà tuyển dụng & ứng viên dễ dàng hơn bao giờ hết.
            </p>

        </div>

        <!-- RIGHT LOGIN CARD -->
        <div class="bg-white/70 glass p-10 rounded-2xl shadow-xl border border-white/40
                    backdrop-blur-xl fade-in-visible">

            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Login</h2>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                {{-- EMAIL --}}
                <div>
                    <label for="email" class="block text-gray-700 text-sm font-semibold mb-1">Email</label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email') }}" required
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
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-300
                                  focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                  shadow-sm transition @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- REMEMBER --}}
                <div class="flex items-center">
                    <input type="checkbox" name="remember"
                           class="rounded text-indigo-600 focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </div>

                {{-- BUTTON --}}
                <button type="submit"
                        class="w-full py-3 bg-indigo-600 text-white rounded-xl font-semibold
                               hover:bg-indigo-700 hover:shadow-xl transform hover:-translate-y-0.5
                               transition-all duration-200">
                    Login
                </button>

                {{-- REGISTER --}}
                <p class="text-center text-gray-600 text-sm">
                    Don’t have an account?
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:underline font-medium">
                        Register here
                    </a>
                </p>
            </form>

        </div>

    </div>
</div>

@endsection
