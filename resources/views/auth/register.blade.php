@extends('layouts.app')

@section('title', 'Register')

@section('content')

<div class="min-h-[75vh] flex items-center justify-center py-10 fade-in">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-5xl w-full px-6">

        <!-- LEFT BANNER -->
        <div class="hidden md:flex flex-col justify-center items-center text-center space-y-6">

            <img src="{{ asset('images/job_banner1.png') }}"
                 alt="Work Illustration"
                 class="w-full max-w-sm rounded-2xl shadow-xl border border-white/30 object-cover">

            <h2 class="text-3xl font-extrabold text-gray-800">
                Create Your <span class="text-indigo-600">JobPortal</span> Account 🚀
            </h2>

            <p class="text-gray-600 leading-relaxed max-w-sm">
                Chọn đúng vai trò của bạn để bắt đầu hành trình tìm việc hoặc đăng tuyển chuyên nghiệp trên nền tảng của chúng tôi.
            </p>

        </div>

        <!-- RIGHT REGISTER FORM -->
        <div class="bg-white/70 glass p-10 rounded-2xl shadow-xl border border-white/40
                    backdrop-blur-xl fade-in-visible">

            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Register</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                {{-- NAME --}}
                <div>
                    <label for="name" class="block text-gray-700 text-sm font-semibold mb-1">Name</label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-300
                                  focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                  shadow-sm transition @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

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

                {{-- CONFIRM PASSWORD --}}
                <div>
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-semibold mb-1">
                        Confirm Password
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-300
                                  focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                </div>

                {{-- ROLE --}}
                <div>
                    <label for="role" class="block text-gray-700 text-sm font-semibold mb-1">I am a</label>
                    <select name="role" id="role" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                   shadow-sm transition @error('role') border-red-500 @enderror">

                        <option value="candidate" {{ old('role', 'candidate') == 'candidate' ? 'selected' : '' }}>
                            Job Seeker
                        </option>
                        <option value="employer" {{ old('role') == 'employer' ? 'selected' : '' }}>
                            Employer
                        </option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- COMPANY NAME (employer only) --}}
                <div class="space-y-1" id="company_name_field"
                     style="{{ old('role') === 'employer' ? '' : 'display: none;' }}">

                    <label for="company_name" class="block text-gray-700 text-sm font-semibold">
                        Company Name
                    </label>

                    <input type="text" name="company_name" id="company_name"
                           value="{{ old('company_name') }}"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300
                                  focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                           {{ old('role') === 'employer' ? 'required' : '' }}>

                    @error('company_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- SUBMIT --}}
                <button type="submit"
                        class="w-full py-3 bg-indigo-600 text-white rounded-xl font-semibold
                               hover:bg-indigo-700 hover:shadow-xl transform hover:-translate-y-0.5
                               transition-all duration-200">
                    Register
                </button>

                {{-- LOGIN LINK --}}
                <p class="text-center text-gray-600 text-sm">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-medium">
                        Login here
                    </a>
                </p>

            </form>

        </div>
    </div>
</div>

{{-- JS giữ nguyên logic employer/candidate --}}
<script>
    document.getElementById('role').addEventListener('change', function() {
        const companyField = document.getElementById('company_name_field');
        if (this.value === 'employer') {
            companyField.style.display = 'block';
            document.getElementById('company_name').required = true;
        } else {
            companyField.style.display = 'none';
            document.getElementById('company_name').required = false;
        }
    });

    if (document.getElementById('role').value === 'employer') {
        const companyField = document.getElementById('company_name_field');
        companyField.style.display = 'block';
        document.getElementById('company_name').required = true;
    }
</script>

@endsection
