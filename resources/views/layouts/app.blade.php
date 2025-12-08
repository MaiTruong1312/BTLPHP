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

    <!-- Cropper.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />

    <!-- Animated Gradient Background -->
    <style>
        body {
            background: linear-gradient(120deg, #dbeafe, #e0e7ff);
            background-size: 300% 300%;
            animation: gradientMove 20s ease infinite;
        }
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .glass {
            backdrop-filter: blur(12px);
            background: rgba(255,255,255,0.3);
        }
    </style>

</head>

<body class="font-sans antialiased text-gray-800"
      x-data="{ open:false, showControl:false, weather:null, time:'' }"
      x-init="
        setInterval(() => {
            const d = new Date();
            time = d.toLocaleTimeString();
        }, 1000);

        fetch('https://api.open-meteo.com/v1/forecast?latitude=21.03&longitude=105.85&current=temperature_2m')
            .then(res=>res.json())
            .then(data => weather = data.current.temperature_2m);
      "
>
    <!-- Mobile Menu Overlay -->
    <div x-show="open" 
         x-transition.opacity 
         class="fixed inset-0 bg-black/50 z-30 sm:hidden"
         @click="open=false">
    </div>

    <!-- Mobile Sidebar -->
    <div x-show="open"
         x-transition
         class="fixed top-0 left-0 w-80 h-full bg-white z-40 sm:hidden shadow-2xl"
         @click.away="open=false">

        <div class="flex justify-between items-center p-4 border-b">
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2H10a2 2 0 00-2 2v2">
                    </path>
                </svg>
                <span class="text-2xl font-bold text-gray-800">JobPortal</span>
            </a>
            <button @click="open=false" class="text-gray-500 hover:text-gray-600">
                ✕
            </button>
        </div>

        <div class="py-4">
            <a href="{{ route('home') }}" 
               class="block px-4 py-2 text-gray-600 hover:bg-gray-100 rounded">
                Jobs
            </a>
            <a href="{{ route('blog.index') }}" 
               class="block px-4 py-2 text-gray-600 hover:bg-gray-100 rounded">
                Blog
            </a>
            <a href="{{ route('about') }}" 
               class="block px-4 py-2 text-gray-600 hover:bg-gray-100 rounded">
                About
            </a>

            @auth
                @if(auth()->user()->isEmployer())
                    <a href="{{ route('jobs.create') }}"
                       class="block px-4 py-2 text-gray-600 hover:bg-gray-100 rounded">
                       Post a Job
                    </a>
                    @can('search-candidates')
                    <a href="{{ route('candidates.search') }}"
                       class="block px-4 py-2 text-gray-600 hover:bg-gray-100 rounded">
                       Find Candidates
                    </a>
                    @endcan
                @endif
            @endauth
        </div>

        <hr>

        <!-- Mobile User -->
        <div class="p-4 space-y-2">
            @auth
                <div class="flex items-center space-x-3">
                    <img class="h-10 w-10 rounded-full"
                         src="{{ auth()->user()->avatar 
                            ? asset('storage/'.auth()->user()->avatar)
                            : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                    >
                    <div>
                        <p class="font-semibold">{{ auth()->user()->name }}</p>
                        <p class="text-gray-500 text-sm">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a>
                <a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-gray-100">My Profile</a>

                @if(auth()->user()->isCandidate())
                    <a href="{{ route('applications.index') }}" class="block px-4 py-2 hover:bg-gray-100">My Applications</a>
                    <a href="{{ route('saved-jobs.index') }}" class="block px-4 py-2 hover:bg-gray-100">Saved Jobs</a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">Logout</button>
                </form>

            @else
                <a href="{{ route('login') }}" class="block px-4 py-2 hover:bg-gray-100">Login</a>
                <a href="{{ route('register') }}" class="block px-4 py-2 hover:bg-gray-100">Register</a>
            @endauth
        </div>

    </div>

    <!-- DESKTOP NAVBAR -->
    <nav class="sticky top-0 z-20 bg-white/70 glass shadow-sm backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex justify-between h-20">

                <!-- LEFT: LOGO -->
                <div class="flex items-center space-x-2">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745" />
                        </svg>
                        <span class="text-2xl font-bold">JobPortal</span>
                    </a>
                </div>

                <!-- CENTER MENU -->
                <div class="hidden sm:flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="nav-link">Jobs</a>
                    <a href="{{ route('blog.index') }}" class="nav-link">Blog</a>
                    <a href="{{ route('about') }}" class="nav-link">About</a>

                    @can('search-candidates')
                         <a href="{{ route('candidates.search') }}" class="nav-link">Find Candidates</a>
                    @endcan

                    @auth
                        @if(auth()->user()->isEmployer())
                            <a href="{{ route('jobs.create') }}" class="nav-btn">Post a Job</a>
                        @endif
                    @endauth
                </div>

                <!-- RIGHT: WEATHER + CLOCK + USER -->
                <div class="hidden sm:flex items-center space-x-6">

                    <!-- Weather -->
                    <div class="flex items-center space-x-1 text-gray-700">
                        <svg class="h-6 w-6 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 18a6 6 0 100-12 6 6 0 000 12z"/>
                        </svg>
                        <span x-text="weather ? weather + '°C' : '...°C'"></span>
                    </div>

                    <!-- Clock -->
                    <div class="font-semibold text-gray-700 tracking-wider" x-text="time"></div>

                    <!-- Notifications -->
                    @auth
                        @include('components.notification-dropdown')
                    @endauth

                    <!-- USER MENU -->
                    @auth
                    <div x-data="{userMenu:false}" class="relative">
                        <button @click="userMenu=!userMenu" id="user-menu-button" class="flex items-center space-x-2">
                            <img class="h-10 w-10 rounded-full"
                                 src="{{ auth()->user()->avatar 
                                     ? asset('storage/'.auth()->user()->avatar)
                                     : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}">
                            <span class="text-gray-700">{{ auth()->user()->name }}</span>
                        </button>

                        <div x-show="userMenu" @click.away="userMenu=false"
                            class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md z-50 py-2">

                            <a href="{{ route('dashboard') }}" class="dropdown-item">Dashboard</a>
                            <a href="{{ route('profile.show') }}" class="dropdown-item">My Profile</a>

                            @if(auth()->user()->isCandidate())
                                <a href="{{ route('applications.index') }}" class="dropdown-item">My Applications</a>
                                <a href="{{ route('saved-jobs.index') }}" class="dropdown-item">Saved Jobs</a>
                            @endif

                            <div class="border-t my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-red-600">Logout</button>
                            </form>

                        </div>
                    </div>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600">Login</a>
                        <a href="{{ route('register') }}" class="nav-btn">Register</a>
                    @endguest

                </div>

                <!-- MOBILE HAMBURGER -->
                <div class="sm:hidden flex items-center">
                    <button @click="open=!open" class="p-2 rounded text-gray-700">
                        ☰
                    </button>
                </div>

            </div>

        </div>
    </nav>
    <!-- PAGE CONTENT -->
    <main class="flex-grow py-10">

        {{-- Flash Success --}}
        @if(session('success'))
        <div x-data="{show:true}" 
             x-show="show" 
             x-transition 
             class="max-w-7xl mx-auto mb-6 px-4 sm:px-6 lg:px-8">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded shadow-md">
                <div class="flex justify-between">
                    <div>
                        <p class="font-bold">Thành công</p>
                        <p>{{ session('success') }}</p>
                    </div>
                    <button @click="show=false" class="text-green-700 text-xl">&times;</button>
                </div>
            </div>
        </div>
        @endif

        {{-- Flash Error --}}
        @if(session('error'))
        <div x-data="{show:true}" 
             x-show="show" 
             x-transition 
             class="max-w-7xl mx-auto mb-6 px-4 sm:px-6 lg:px-8">
            <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded shadow-md">
                <div class="flex justify-between">
                    <div>
                        <p class="font-bold">Lỗi</p>
                        <p>{{ session('error') }}</p>
                    </div>
                    <button @click="show=false" class="text-red-700 text-xl">&times;</button>
                </div>
            </div>
        </div>
        @endif


        <!-- ACTUAL PAGE CONTENT -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>

    </main>


    <!-- FLOATING QUICK BUTTON -->
    <div x-data="{
            openQuick: false,
            dragging: false,
            position: { x: window.innerWidth - 150, y: window.innerHeight - 150 },
            popupClasses: 'absolute bottom-full mb-2'
         }"
         x-init="
            const userMenuBtn = document.getElementById('user-menu-button');
            if (userMenuBtn) {
                const rect = userMenuBtn.getBoundingClientRect();
                position.x = rect.right + 20;
                position.y = rect.top + (rect.height / 2) - 28; // 28 là một nửa chiều cao của nút
            }
         "
         @mousemove.window="if (dragging) {
            position.x = $event.clientX - 28; /* 28 là một nửa chiều rộng của nút (w-14) */
            position.y = $event.clientY - 28; /* 28 là một nửa chiều cao của nút (h-14) */
         }"
         @mouseup.window="dragging = false"
         @click="if (!dragging) {
            openQuick = !openQuick;
            let classes = 'absolute w-56 ';
            classes += (position.y < window.innerHeight / 2) ? 'top-full mt-2 ' : 'bottom-full mb-2 ';
            classes += (position.x < window.innerWidth / 2) ? 'left-0 ' : 'right-0 ';
            popupClasses = classes;
         }"
         :style="`position: fixed; top: ${position.y}px; left: ${position.x}px;`"
         class="z-40 cursor-grab"
         :class="{ 'cursor-grabbing': dragging }"
    >

        <!-- Button -->
        <button 
            @mousedown="
                if ($event.target === $el) { // Chỉ kéo khi nhấn vào nút, không phải popup
                    dragging = true;
                }
            "
            class="bg-indigo-600 text-white w-14 h-14 rounded-full shadow-lg
                   flex items-center justify-center text-3xl hover:bg-indigo-700 transition select-none">
            ☰
        </button>

        <!-- Popup -->
        <div x-show="openQuick"
             x-transition
             @click.away="openQuick=false"
             :class="popupClasses + ' bg-white shadow-xl rounded-lg p-4 border cursor-default'">

            @auth
                <h3 class="text-sm font-semibold text-gray-600 mb-3">Quick Menu</h3>

                <a href="{{ route('dashboard') }}" class="quick-item">Dashboard</a>
                <a href="{{ route('profile.show') }}" class="quick-item">My Profile</a>
                <a href="{{ route('home') }}" class="quick-item">Browse Jobs</a>

                {{-- Chỉ hiển thị cho ứng viên --}}
                @if(auth()->user()->isCandidate())
                    <a href="{{ route('saved-jobs.index') }}" class="quick-item">Saved Jobs</a>
                @endif

                {{-- Chỉ hiển thị cho nhà tuyển dụng --}}
                @if(auth()->user()->isEmployer())
                    <a href="{{ route('jobs.create') }}" class="quick-item">Post a New Job</a>
                @endif

                <form method="POST" action="{{ route('logout') }}" class="mt-2 border-t pt-2">
                    @csrf
                    <button class="quick-item text-red-600 w-full text-left">Logout</button>
                </form>
            @endauth
        </div>
    </div>


    <!-- SPOTIFY MINI PLAYER -->
    <div class="fixed bottom-6 left-6 w-64 glass p-4 rounded-xl shadow-xl">
        <h3 class="font-semibold text-gray-800 mb-2 text-sm flex justify-between">
            Spotify Mini Player
            <button onclick="document.getElementById('spotifyFrame').classList.toggle('hidden')" class="text-xs text-indigo-600">Toggle</button>
        </h3>

        <iframe id="spotifyFrame"
                style="border-radius:8px"
                src="https://open.spotify.com/embed/playlist/37i9dQZF1DXcBWIGoYBM5M?utm_source=generator"
                width="100%" height="152" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                loading="lazy"
                class="shadow-md">
        </iframe>
    </div>


    <!-- STYLES -->
    <style>
        .quick-item {
            display:block;
            padding:8px 10px;
            border-radius:6px;
            font-size:14px;
            color:#374151;
            transition:.2s;
        }
        .quick-item:hover {
            background:#f3f4f6;
            color:#111827;
        }
        .glass {
            background: rgba(255,255,255,0.25);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.3);
        }
    </style>
    <!-- =============================== -->
    <!-- 🔥 FOOTER PREMIUM + WIDGETS     -->
    <!-- =============================== -->

    <footer class="mt-20 bg-gray-900 text-gray-300">
        <div class="max-w-7xl mx-auto py-16 px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-12">

            <!-- Column 1 -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">JobPortal</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Tìm kiếm công việc, cơ hội nghề nghiệp và kết nối nhà tuyển dụng hàng đầu.
                </p>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="hover:text-white">🌐</a>
                    <a href="#" class="hover:text-white">🐦</a>
                    <a href="#" class="hover:text-white">📘</a>
                </div>
            </div>

            <!-- Column 2 -->
            <div>
                <h4 class="text-white text-sm uppercase mb-4">For Candidates</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-white">Browse Jobs</a></li>
                    <li><a href="{{ route('saved-jobs.index') }}" class="hover:text-white">Saved Jobs</a></li>
                    <li><a href="{{ route('applications.index') }}" class="hover:text-white">My Applications</a></li>
                    <li><a href="{{ route('profile.show') }}" class="hover:text-white">My Profile</a></li>
                </ul>
            </div>

            <!-- Column 3 -->
            <div>
                <h4 class="text-white text-sm uppercase mb-4">Employers</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('jobs.create') }}" class="hover:text-white">Post a Job</a></li>
                    <li><a href="{{ route('dashboard') }}" class="hover:text-white">Manage Jobs</a></li>
                    <li><a href="{{ route('admin.applications.index') }}" class="hover:text-white">Manage Applications</a></li>
                </ul>
            </div>

            <!-- Column 4 -->
            <div>
                <h4 class="text-white text-sm uppercase mb-4">Company</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('about') }}" class="hover:text-white">About Us</a></li>
                    <li><a href="{{ route('blog.index') }}" class="hover:text-white">Blog</a></li>
                    <li><a href="{{ route('privacy') }}" class="hover:text-white">Privacy Policy</a></li>
                    <li><a href="{{ route('terms') }}" class="hover:text-white">Terms of Service</a></li>
                </ul>
            </div>

        </div>

        <div class="border-t border-gray-700 py-6 text-center text-gray-500 text-sm">
            © {{ date('Y') }} JobPortal — All rights reserved.
        </div>
    </footer>


    <!-- ========================================= -->
    <!-- 🌟 WIDGET 1 — Random Job Quote (Auto Change) -->
    <!-- ========================================= -->
    <div class="fixed bottom-6 right-[26rem] bg-white shadow-xl p-4 rounded-xl w-60 border z-40"
         x-data="{quoteIndex:0, quotes:[
             'Success is not for the lazy.',
             'Do what you love and success will follow.',
             'The future depends on what you do today.',
             'Dream big. Work hard. Stay focused.',
             'Opportunities don’t happen. You create them.'
         ]}"
         x-init="setInterval(()=>quoteIndex=(quoteIndex+1)%quotes.length, 5000)"
    >
        <h4 class="font-semibold text-gray-700 text-sm mb-2">✨ Motivational</h4>
        <p class="text-gray-600 text-sm" x-text="quotes[quoteIndex]"></p>
    </div>


    <!-- ========================================= -->
    <!-- 🌤️ WIDGET 2 — Weather Quick Popup         -->
    <!-- ========================================= -->
    <div x-data="{showWeather:false, weather:{temp:0,desc:'...'}}"
         x-init="fetch('https://api.open-meteo.com/v1/forecast?latitude=21.02&longitude=105.83&current_weather=true')
                 .then(res=>res.json())
                 .then(data=>{
                     weather.temp = data.current_weather.temperature;
                     weather.desc = data.current_weather.weathercode;
                 })"
         class="fixed bottom-6 left-80 z-40">

        <button @click="showWeather=!showWeather"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
            🌤️ Weather
        </button>

        <div x-show="showWeather" x-transition @click.away="showWeather=false"
             class="mt-3 bg-white border shadow-xl p-4 rounded-xl w-56">
            <h4 class="font-semibold text-gray-700 mb-2 text-sm">Hà Nội — Current Weather</h4>
            <p class="text-gray-800 text-xl font-bold" x-text="weather.temp + '°C'"></p>
            <p class="text-gray-500 text-sm mt-1">Code: <span x-text="weather.desc"></span></p>
        </div>
    </div>


    <!-- ========================================= -->
    <!-- 💬 WIDGET 3 — Quick Mini Support Chat     -->
    <!-- ========================================= -->
    <div x-data="{
            openChat: false,
            draggingChat: false,
            chatPosition: { x: 300, y: window.innerHeight - 100 },
            messages:['Hi! Tôi có thể giúp gì cho bạn?']
         }"
         @mousemove.window="if (draggingChat) {
            chatPosition.x = $event.clientX - 28;
            chatPosition.y = $event.clientY - 28;
         }"
         @mouseup.window="draggingChat = false"
         :style="`position: fixed; top: ${chatPosition.y}px; left: ${chatPosition.x}px;`"
         class="z-40 cursor-grab"
         :class="{ 'cursor-grabbing': draggingChat }"
    >

        <button @click="!draggingChat && (openChat = !openChat)"
                @mousedown="
                    if ($event.target === $el) {
                        draggingChat = true;
                    }
                "
                class="bg-green-600 text-white w-14 h-14 rounded-full flex items-center justify-center text-2xl shadow hover:bg-green-700">
            💬
        </button>

        <div x-show="openChat" x-transition @click.away="openChat=false"
             class="absolute bottom-full mb-2 bg-white border rounded-xl shadow-xl w-72 p-4 cursor-default">

            <h3 class="text-sm font-semibold text-gray-700 mb-3">Hỗ trợ nhanh</h3>

            <div class="h-40 overflow-y-auto space-y-2 mb-3">
                <template x-for="msg in messages">
                    <div class="bg-gray-100 p-2 rounded-md text-sm" x-text="msg"></div>
                </template>
            </div>

            <input type="text"
                   placeholder="Nhập câu hỏi…"
                   class="border rounded-lg w-full px-3 py-2 text-sm"
                   @keydown.enter="
                       if($event.target.value.trim()!=''){
                            messages.push($event.target.value);
                            $event.target.value='';
                       }
                   ">
        </div>

    </div>
    <!-- ========================================================= -->
    <!--  ⏰ LIVE CLOCK + ANIMATIONS + INTERACTIONS (FINAL SCRIPTS) -->
    <!-- ========================================================= -->

    <script>
        // 🕒 Real-time Digital Clock
        document.addEventListener("DOMContentLoaded", () => {
            function updateClock() {
                const clock = document.getElementById("live-clock");
                if (!clock) return;

                const now = new Date();
                clock.innerText =
                    now.toLocaleTimeString("vi-VN", { hour12: false }) +
                    " — " +
                    now.toLocaleDateString("vi-VN");
            }
            setInterval(updateClock, 1000);
            updateClock();
        });

        // 🎯 Scroll Fade Animation
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add("fade-in-visible");
            });
        });
        document.querySelectorAll(".fade-in").forEach(el => observer.observe(el));

        // 🌟 Parallax Hover
        document.addEventListener("mousemove", function(e) {
            document.querySelectorAll("[data-parallax]").forEach(layer => {
                const speed = layer.getAttribute("data-parallax");
                const x = (window.innerWidth - e.pageX * speed) / 200;
                const y = (window.innerHeight - e.pageY * speed) / 200;
                layer.style.transform = `translateX(${x}px) translateY(${y}px)`;
            });
        });

        // 🔥 Neon Glow Hover Effect
        document.querySelectorAll(".glow-hover").forEach((el) => {
            el.addEventListener("mouseenter", () => {
                el.classList.add("shadow-lg", "shadow-indigo-500/50");
            });
            el.addEventListener("mouseleave", () => {
                el.classList.remove("shadow-lg", "shadow-indigo-500/50");
            });
        });
    </script>

    <style>
        /* Fade in animation */
        .fade-in { opacity: 0; transform: translateY(20px); transition: 0.6s; }
        .fade-in-visible { opacity: 1; transform: translateY(0); }

        /* Neon glow hover */
        .glow-hover { transition: 0.3s ease; }
    </style>

    <!-- CropperJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

    <!-- Stack scripts -->
    @stack('scripts')

</body>
</html>
