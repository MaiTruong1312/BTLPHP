@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="bg-gray-50 relative overflow-hidden">
    {{-- Background global blur shapes --}}
    <div class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute -top-32 -left-32 w-80 h-80 bg-blue-200 rounded-full blur-3xl opacity-40"></div>
        <div class="absolute top-1/2 -right-32 w-72 h-72 bg-indigo-200 rounded-full blur-3xl opacity-40"></div>
        <div class="absolute bottom-0 left-1/3 w-64 h-64 bg-sky-100 rounded-full blur-3xl opacity-40"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- HERO SECTION --}}
        <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-800 rounded-2xl shadow-2xl p-8 md:p-10 mb-10 text-white relative overflow-hidden">
            {{-- Background soft circles --}}
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-500/30 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 -left-10 w-52 h-52 bg-indigo-500/20 rounded-full blur-3xl"></div>

            {{-- Subtle gradient line on top --}}
            <div class="absolute inset-x-10 top-0 h-px bg-gradient-to-r from-transparent via-white/50 to-transparent opacity-60"></div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                {{-- Left: Text + Search Form --}}
                <div class="space-y-7">
                    <div class="inline-flex items-center space-x-2 bg-white/10 px-3 py-1 rounded-full text-xs md:text-sm backdrop-blur-sm border border-white/20">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        <span class="w-2 h-2 rounded-full bg-emerald-300 rounded-full -ml-2"></span>
                        <span>Hàng ngàn việc làm mới mỗi ngày</span>
                    </div>

                    <div>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-3 leading-tight tracking-tight">
                            Find Your
                            <span class="text-yellow-300 drop-shadow-md">Dream Job</span>
                        </h1>
                        <p class="text-base md:text-lg lg:text-xl text-blue-100 max-w-xl">
                            Discover thousands of job opportunities from top companies,
                            phù hợp với kỹ năng &amp; sở thích của bạn.
                        </p>
                    </div>

                    {{-- Quick stats --}}
                    <div class="grid grid-cols-3 gap-4 text-xs md:text-sm">
                        <div class="bg-white/10 rounded-xl px-3 py-3 border border-white/10 flex flex-col gap-1">
                            <span class="text-[11px] uppercase tracking-wide text-blue-100">Việc làm</span>
                            <span class="font-semibold text-white text-lg md:text-xl">{{ number_format($stats['jobs_count']) }}+</span>
                            <span class="text-[11px] text-blue-100">Đang tuyển</span>
                        </div>
                        <div class="bg-white/10 rounded-xl px-3 py-3 border border-white/10 flex flex-col gap-1">
                            <span class="text-[11px] uppercase tracking-wide text-blue-100">Công ty</span>
                            <span class="font-semibold text-white text-lg md:text-xl">{{ number_format($stats['companies_count']) }}+</span>
                            <span class="text-[11px] text-blue-100">Đối tác</span>
                        </div>
                        <div class="bg-white/10 rounded-xl px-3 py-3 border border-white/10 flex flex-col gap-1">
                            <span class="text-[11px] uppercase tracking-wide text-blue-100">Hôm nay</span>
                            <span class="font-semibold text-white text-lg md:text-xl">{{ number_format($stats['jobs_today_count']) }}+</span>
                            <span class="text-[11px] text-blue-100">Việc mới</span>
                        </div>
                    </div>

                    {{-- SEARCH FORM --}}
                    <form action="{{ route('home') }}" method="GET" class="space-y-4 mt-3 md:mt-4 bg-white/10 rounded-2xl p-4 md:p-5 backdrop-blur-sm border border-white/10">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                                    🔍
                                </span>
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Job title, keywords..."
                                    class="pl-9 pr-4 py-3 rounded-lg text-gray-900 w-full focus:outline-none focus:ring-2 focus:ring-blue-400"
                                >
                            </div>

                            <div class="relative">
                                <select
                                    name="category"
                                    class="px-4 py-3 rounded-lg text-gray-900 w-full focus:outline-none focus:ring-2 focus:ring-blue-400"
                                >
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="relative">
                                <select
                                    name="location"
                                    class="px-4 py-3 rounded-lg text-gray-900 w-full focus:outline-none focus:ring-2 focus:ring-blue-400"
                                >
                                    <option value="">All Locations</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}" {{ request('location') == $location->id ? 'selected' : '' }}>
                                            {{ $location->city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                            <div class="md:col-span-2">
                                <select
                                    name="salary_range"
                                    class="px-4 py-3 rounded-lg text-gray-900 w-full focus:outline-none focus:ring-2 focus:ring-blue-400"
                                >
                                    <option value="">All Salaries</option>
                                    <option value="1000000" {{ request('salary_range') == '1000000' ? 'selected' : '' }}>Trên 1 triệu</option>
                                    <option value="2000000" {{ request('salary_range') == '2000000' ? 'selected' : '' }}>Trên 2 triệu</option>
                                    <option value="5000000" {{ request('salary_range') == '5000000' ? 'selected' : '' }}>Trên 5 triệu</option>
                                    <option value="10000000" {{ request('salary_range') == '10000000' ? 'selected' : '' }}>Trên 10 triệu</option>
                                    <option value="15000000" {{ request('salary_range') == '15000000' ? 'selected' : '' }}>Trên 15 triệu</option>
                                    <option value="20000000" {{ request('salary_range') == '20000000' ? 'selected' : '' }}>Trên 20 triệu</option>
                                    <option value="30000000" {{ request('salary_range') == '30000000' ? 'selected' : '' }}>Trên 30 triệu</option>
                                    <option value="50000000" {{ request('salary_range') == '50000000' ? 'selected' : '' }}>Trên 50 triệu</option>
                                    <option value="negotiable" {{ request('salary_range') == 'negotiable' ? 'selected' : '' }}>Thương lượng</option>
                                </select>
                            </div>
                            <button
                                type="submit"
                                class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 w-full shadow-md hover:shadow-xl transition-transform duration-200 transform hover:-translate-y-0.5"
                            >
                                Search
                            </button>
                        </div>

                        {{-- Filter summary nhỏ --}}
                        @if(request('search') || request('category') || request('location') || request('salary_range'))
                            <div class="flex flex-wrap gap-2 text-xs mt-2 text-blue-100">
                                <span class="uppercase tracking-wide text-[11px] text-blue-100/80">Active filters:</span>
                                @if(request('search'))
                                    <span class="px-2 py-1 rounded-full bg-white/10 border border-white/20">Search: "{{ request('search') }}"</span>
                                @endif
                                @if(request('category'))
                                    <span class="px-2 py-1 rounded-full bg-white/10 border border-white/20">
                                        Category: {{ optional($categories->firstWhere('id', request('category')))->name }}
                                    </span>
                                @endif
                                @if(request('location'))
                                    <span class="px-2 py-1 rounded-full bg-white/10 border border-white/20">
                                        Location: {{ optional($locations->firstWhere('id', request('location')))->city }}
                                    </span>
                                @endif
                                @if(request('salary_range'))
                                    <span class="px-2 py-1 rounded-full bg-white/10 border border-white/20">
                                        Salary: {{ request('salary_range') === 'negotiable' ? 'Thương lượng' : 'Trên ' . number_format(request('salary_range')) }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    </form>
                </div>

                {{-- Right: Image frame --}}
                <div class="hidden lg:block">
                    <div class="relative">
                        <div class="absolute -top-5 -right-4 w-24 h-24 bg-yellow-300/40 rounded-full blur-2xl"></div>
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 shadow-xl transform hover:rotate-1 hover:-translate-y-1 transition duration-300">
                            <div class="relative rounded-xl overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-tr from-blue-500/10 via-transparent to-yellow-300/10 pointer-events-none"></div>
                                <img src="{{ asset('images/banner.png') }}" alt="Job Hero" class="w-full h-full object-cover aspect-[4/3]">
                            </div>
                        </div>

                        {{-- Floating small card --}}
                        <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 bg-white/95 text-gray-800 rounded-2xl shadow-xl px-4 py-3 flex items-center gap-3 text-xs border border-blue-50">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-lg">
                                ⭐
                            </div>
                            <div class="flex flex-col leading-tight">
                                <span class="font-semibold text-[12px]">Được tin dùng bởi developer</span>
                                <span class="text-[11px] text-gray-500">Tìm việc nhanh, lọc job chuẩn, UI không bị phèn 😎</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- FEATURED COMPANIES --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-sm px-6 py-4 flex flex-col gap-3 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="text-xs px-2 py-1 rounded-full bg-blue-50 text-blue-600 font-semibold">Top Hiring</span>
                        <h2 class="text-sm md:text-base font-semibold text-gray-800 tracking-tight">
                            Featured Companies
                        </h2>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    @forelse($featuredCompanies as $company)
                        <div class="h-12 w-28 rounded-lg border border-gray-200 bg-white p-1 flex items-center justify-center hover:border-blue-300 hover:shadow-sm transition">
                            <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->company_name }} Logo" class="max-h-full max-w-full object-contain">
                        </div>
                    @empty
                        <p class="text-xs text-gray-400">Chưa có công ty nổi bật nào.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- QUICK CATEGORIES / TAGS (để nhìn cho xịn, chưa cần logic) --}}
        <div class="mb-6">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                    Popular Categories
                </h2>
            </div>
            <div class="flex flex-wrap gap-2">
                @foreach($popularCategories as $category)
                    <a href="{{ route('home', ['category' => $category->id]) }}" class="px-3 py-1.5 rounded-full bg-gray-100 text-gray-700 text-xs font-medium hover:bg-blue-100 hover:text-blue-700 transition">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- JOB LIST HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Latest Jobs</h2>
                <p class="text-sm text-gray-500">
                    Việc mới được cập nhật liên tục. Lọc kỹ thông tin, đọc mô tả chi tiết trước khi apply.
                </p>
            </div>
            <div class="mt-3 md:mt-0 flex items-center gap-2 text-xs text-gray-500">
                <span class="px-2 py-1 rounded-full bg-gray-100">
                    {{ $jobs->total() }} jobs found
                </span>
            </div>
        </div>

        {{-- JOB LISTING --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($jobs as $job)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group border border-gray-100">
                    {{-- Khung ảnh cho mỗi job --}}
                    <div class="relative">
                        <div class="h-32 w-full bg-gray-100 overflow-hidden">
                            <img src="{{ asset('images/job_banner' . rand(1, 6) . '.png') }}" alt="{{ $job->title }}" class="w-full h-full object-cover">
                        </div>

                        {{-- Badge nhỏ ở góc ảnh --}}
                        <div class="absolute top-2 left-2 flex flex-col gap-1">
                            <span class="px-2 py-1 text-[10px] rounded-full bg-white/90 text-blue-600 font-semibold shadow-sm">
                                New
                            </span>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-start gap-2">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                    <a href="{{ route('jobs.show', $job->slug) }}">
                                        {{ $job->title }}
                                    </a>
                                </h3>
                                <p class="text-[13px] text-gray-500 mt-1">
                                    {{ $job->employerProfile->company_name ?? 'Top Company' }}
                                </p>
                            </div>
                        </div>

                        <p class="text-gray-600 text-sm mb-2 line-clamp-3">
                            {{ $job->short_description ?? Str::limit($job->description, 100) }}
                        </p>

                        <div class="flex flex-wrap gap-2 mb-2">
                            <span class="px-3 py-1 bg-blue-50 text-blue-700 text-[11px] rounded-full">
                                {{ $job->category->name }}
                            </span>
                            <span class="px-3 py-1 bg-green-50 text-green-700 text-[11px] rounded-full">
                                {{ $job->location->city }}
                            </span>
                            <span class="px-3 py-1 bg-purple-50 text-purple-700 text-[11px] rounded-full">
                                {{ ucfirst(str_replace('_', ' ', $job->job_type)) }}
                            </span>
                        </div>

                        @if($job->salary_min || $job->salary_max)
                            <p class="text-gray-800 font-semibold text-sm">
                                @if($job->salary_min && $job->salary_max)
                                    {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} {{ $job->currency }}/{{ $job->salary_type }}
                                @elseif($job->salary_min)
                                    From {{ number_format($job->salary_min) }} {{ $job->currency }}/{{ $job->salary_type }}
                                @else
                                    Negotiable
                                @endif
                            </p>
                        @endif

                        <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                            <span class="text-xs text-gray-500 flex items-center gap-1">
                                ⏱ {{ $job->created_at->diffForHumans() }}
                            </span>
                            <a
                                href="{{ route('jobs.show', $job->slug) }}"
                                class="text-sm text-blue-600 hover:text-blue-800 font-medium inline-flex items-center gap-1"
                            >
                                View Details
                                <span class="group-hover:translate-x-1 transition-transform">→</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="mx-auto w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                        😔
                    </div>
                    <p class="text-gray-700 text-lg font-semibold mb-1">No jobs found</p>
                    <p class="text-gray-500 text-sm mb-4">
                        Try adjusting your search criteria hoặc xoá bớt filter.
                    </p>
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-full bg-blue-600 text-white hover:bg-blue-700">
                        Clear filters
                    </a>
                </div>
            @endforelse
        </div>

        @if ($jobs->hasPages())
            <div class="mt-10">
                {{ $jobs->links() }}
            </div>
        @endif
    </div>

    {{-- Floating CTA (trang trí, bạn có thể sửa route sau) --}}
    <div class="fixed bottom-6 right-6 z-40 hidden md:flex">
        <div class="bg-white/95 border border-blue-100 shadow-2xl rounded-2xl px-4 py-3 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-lg">
                📢
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-semibold text-gray-800">Bạn là nhà tuyển dụng?</span>
                <span class="text-[11px] text-gray-500">Đăng tin tuyển dụng chỉ trong vài phút.</span>
            </div>
            <a href="{{ route('jobs.create') }}"
               class="ml-2 inline-flex items-center px-3 py-1.5 rounded-full bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700">
                Post a job
            </a>
        </div>
    </div>
</div>
@endsection
