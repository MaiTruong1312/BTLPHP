<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Job Portal') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Cropper.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">
    <div x-data="{ open: false }" @keydown.window.escape="open = false" class="bg-gray-50">
        
        <!-- Mobile Menu Overlay -->
        <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 z-30 sm:hidden" @click="open = false"></div>

        <!-- Mobile Menu Panel -->
        <div x-show="open" 
             x-transition:enter="transition ease-in-out duration-300 transform" 
             x-transition:enter-start="-translate-x-full" 
             x-transition:enter-end="translate-x-0" 
             x-transition:leave="transition ease-in-out duration-300 transform" 
             x-transition:leave-start="translate-x-0" 
             x-transition:leave-end="-translate-x-full" 
             class="fixed top-0 left-0 w-80 h-full bg-white z-40 sm:hidden shadow-2xl"
             @click.away="open = false">
            
            <div class="flex justify-between items-center p-4 border-b">
                 <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center space-x-2">
                    <svg class="h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="text-2xl font-bold text-gray-800">JobPortal</span>
                </a>
                <button @click="open = false" class="text-gray-500 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="py-4">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('home') || request()->routeIs('jobs.show') ? 'border-indigo-500 text-indigo-700 bg-indigo-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition">Jobs</a>
                    <a href="{{ route('blog.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('blog.*') ? 'border-indigo-500 text-indigo-700 bg-indigo-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition">Blog</a>
                    <a href="{{ route('about') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('about') ? 'border-indigo-500 text-indigo-700 bg-indigo-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition">About</a>
                     @auth
                        @if(auth()->user()->isEmployer())
                            <a href="{{ route('jobs.create') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-indigo-500 transition">Post a Job</a>
                        @endif
                    @endauth
                </div>
                <div class="pt-4 pb-3 border-t border-gray-200">
                     @auth
                        <div class="flex items-center px-4">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="">
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium text-gray-800">{{ auth()->user()->name }}</div>
                                <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                            </div>
                        </div>
                        <div class="mt-3 space-y-1">
                             <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-50 transition">Dashboard</a>
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-50 transition">My Profile</a>
                            @if(auth()->user()->isCandidate())
                                <a href="{{ route('applications.index') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-50 transition">My Applications</a>
                                <a href="{{ route('saved-jobs.index') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-50 transition">Saved Jobs</a>
                            @endif
                             @if(auth()->user()->isAdmin())
                                <div class="border-t border-gray-200 my-1"></div>
                                <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-50 transition">Manage Users</a>
                                <a href="{{ route('admin.jobs.index') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-50 transition">Manage Jobs</a>
                                <a href="{{ route('admin.applications.index') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-50 transition">Manage Applications</a>
                            @endif
                            <div class="border-t border-gray-200 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-red-600 hover:bg-gray-100 transition">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="space-y-1">
                            <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-50 transition">Login</a>
                            <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-50 transition">Register</a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>

        <div class="flex flex-col min-h-screen">
            <!-- Navigation -->
            <nav class="sticky top-0 z-20 bg-white/80 backdrop-blur-sm shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-24">
                        <div class="flex items-center">
                            <!-- Logo -->
                            <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center space-x-2">
                                <svg class="h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="text-2xl font-bold text-gray-800">JobPortal</span>
                            </a>
                        </div>

                        <!-- Primary Nav -->
                        <div class="hidden sm:flex items-center space-x-1">
                            <a href="{{ route('home') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('home') || request()->routeIs('jobs.show') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700' }} hover:text-indigo-600 hover:bg-indigo-50 transition-colors duration-200">Jobs</a>
                            <a href="{{ route('blog.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('blog.*') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700' }} hover:text-indigo-600 hover:bg-indigo-50 transition-colors duration-200">Blog</a>
                            <a href="{{ route('about') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('about') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700' }} hover:text-indigo-600 hover:bg-indigo-50 transition-colors duration-200">About</a>
                            @auth
                                @if(auth()->user()->isEmployer())
                                    <a href="{{ route('jobs.create') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-100/50 transition-all duration-300 transform hover:-translate-y-0.5">Post a Job</a>
                                @endif
                            @endauth
                        </div>

                        <!-- Secondary Nav & User Menu -->
                        <div class="hidden sm:flex items-center space-x-4">
                            @guest
                                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600 transition-colors duration-300">Login</a>
                                <a href="{{ route('register') }}" class="px-4 py-2 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-colors duration-300 shadow-sm hover:shadow-md">Register</a>
                            @endguest
                            @auth
                            <div x-data="{ dropdownOpen: false }" class="relative">
                                <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 focus:outline-none">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ auth()->user()->name }}">
                                    <span class="hidden lg:inline text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div x-show="dropdownOpen" 
                                     @click.away="dropdownOpen = false" 
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 transform scale-95"
                                     x-transition:enter-end="opacity-100 transform scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 transform scale-100"
                                     x-transition:leave-end="opacity-0 transform scale-95">
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">Dashboard</a>
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">My Profile</a>
                                    @if(auth()->user()->isCandidate())
                                        <a href="{{ route('applications.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">My Applications</a>
                                        <a href="{{ route('saved-jobs.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">Saved Jobs</a>
                                    @endif
                                    @if(auth()->user()->isAdmin())
                                        <div class="border-t border-gray-200 my-1"></div>
                                        <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">Manage Users</a>
                                        <a href="{{ route('admin.jobs.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">Manage Jobs</a>
                                        <a href="{{ route('admin.applications.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">Manage Applications</a>
                                    @endif
                                    <div class="border-t border-gray-200 my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 transition">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endauth
                        </div>

                        <!-- Mobile Menu Button -->
                        <div class="sm:hidden flex items-center">
                            <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                <span class="sr-only">Mở menu chính</span>
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="flex-grow py-10">
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded-r-lg shadow-md" role="alert">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-bold">Thành công</p>
                                    <p>{{ session('success') }}</p>
                                </div>
                                <button @click="show = false" class="text-green-800 hover:text-green-600">&times;</button>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded-r-lg shadow-md" role="alert">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-bold">Lỗi</p>
                                    <p>{{ session('error') }}</p>
                                </div>
                                <button @click="show = false" class="text-red-800 hover:text-red-600">&times;</button>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-gray-800 text-gray-300">
                <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                        <div class="space-y-4">
                            <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">For Candidates</h3>
                            <ul class="space-y-2">
                                <li><a href="{{ route('jobs.index') }}" class="text-base text-gray-300 hover:text-white">Browse Jobs</a></li>
                                @auth
                                    @if(auth()->user()->isCandidate())
                                        <li><a href="{{ route('saved-jobs.index') }}" class="text-base text-gray-300 hover:text-white">Saved Jobs</a></li>
                                        <li><a href="{{ route('applications.index') }}" class="text-base text-gray-300 hover:text-white">My Applications</a></li>
                                        <li><a href="{{ route('profile.show') }}" class="text-base text-gray-300 hover:text-white">My Profile</a></li>
                                    @endif
                                @endauth
                            </ul>
                        </div>
                        <div class="space-y-4">
                            <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">For Employers</h3>
                            <ul class="space-y-2">
                                <li><a href="{{ route('jobs.create') }}" class="text-base text-gray-300 hover:text-white">Post a Job</a></li>
                                @auth
                                    @if(auth()->user()->isEmployer() || auth()->user()->isAdmin())
                                        <li><a href="{{ route('dashboard') }}" class="text-base text-gray-300 hover:text-white">Manage Jobs</a></li>
                                        <li><a href="{{ route('admin.applications.index') }}" class="text-base text-gray-300 hover:text-white">Manage Applications</a></li>
                                    @endif
                                @endauth
                            </ul>
                        </div>
                        <div class="space-y-4">
                            <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Company</h3>
                            <ul class="space-y-2">
                                <li><a href="{{ route('about') }}" class="text-base text-gray-300 hover:text-white">About Us</a></li>
                                <li><a href="{{ route('blog.index') }}" class="text-base text-gray-300 hover:text-white">Blog</a></li>
                            </ul>
                        </div>
                        <div class="space-y-4">
                            <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Legal</h3>
                            <ul class="space-y-2">
                                <li><a href="{{ route('privacy') }}" class="text-base text-gray-300 hover:text-white">Privacy Policy</a></li>
                                <li><a href="{{ route('terms') }}" class="text-base text-gray-300 hover:text-white">Terms of Service</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="mt-12 border-t border-gray-700 pt-8 flex items-center justify-between">
                        <p class="text-base text-gray-400">&copy; {{ date('Y') }} Job Portal. All rights reserved.</p>
                        <div class="flex space-x-6">
                            <a href="#" class="text-gray-400 hover:text-white">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <span class="sr-only">GitHub</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.418 2.865 8.165 6.839 9.49.5.092.682-.217.682-.482 0-.237-.009-.868-.014-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.031-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.03 1.595 1.03 2.688 0 3.848-2.338 4.695-4.566 4.942.359.308.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.001 10.001 0 0022 12c0-5.523-4.477-10-10-10z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    @stack('scripts')
</body>
</html>