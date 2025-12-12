
{{-- resources/views/auth/verify.blade.php --}}
@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-10">
    <div class="max-w-md w-full bg-white/70 glass p-8 rounded-2xl shadow-xl border border-white/40 text-center">

        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            Verify your email to continue
        </h2>

        <p class="text-gray-600 mb-6">
            Before proceeding, please check your email for a verification link.
            If you did not receive the email, you can request another.
        </p>

        @if (session('resent'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                A fresh verification link has been sent to your email address.
            </div>
        @endif

        <div class="flex flex-col space-y-4">
            {{-- Nút đến Gmail --}}
            <a href="https://mail.google.com/" target="_blank"
               class="w-full py-3 bg-blue-600 text-white rounded-xl font-semibold
                      hover:bg-blue-700 transition-all duration-200">
                Go to Gmail Inbox
            </a>

            {{-- Nút gửi lại email --}}
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                        class="w-full py-3 bg-gray-600 text-white rounded-xl font-semibold
                               hover:bg-gray-700 transition-all duration-200">
                    Send Again
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
