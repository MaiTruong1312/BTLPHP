<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">
    <div class="flex">
        <!-- Admin Sidebar -->
        @include('components.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen">
            <!-- Top Bar -->
            <header class="sticky top-0 bg-white shadow-sm z-10">
                <div class="flex justify-between items-center h-16 px-4 sm:px-6 lg:px-8">
                    <!-- Left side can have breadcrumbs or title -->
                    <h1 class="text-xl font-semibold text-gray-800">@yield('title')</h1>
                    
                    <!-- Right side with User menu -->
                    <div class="flex items-center">
                         @auth
                            @include('components.notification-dropdown')
                            <div x-data="{ dropdownOpen: false }" class="relative ml-4">
                                <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 focus:outline-none">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}">
                                    <span class="hidden lg:inline text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div x-show="dropdownOpen" 
                                     @click.away="dropdownOpen = false" 
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" 
                                     x-transition>
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">My Profile</a>
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
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-grow py-10">
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded-r-lg shadow-md" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                     <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded-r-lg shadow-md" role="alert">
                            <p>{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
