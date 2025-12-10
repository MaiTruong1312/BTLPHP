@extends('layouts.app')

@section('title', 'Our Blog')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-96 flex items-center justify-center text-center">
        <div>
            <h1 class="text-5xl font-extrabold mb-4">JobPortal Blog</h1>
            <p class="text-xl text-indigo-100">Latest job tips, industry trends, and company news updates.</p>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Blog Post 1 -->
        <article class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden flex flex-col h-full">
            <!-- Image Section -->
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 h-48 flex items-center justify-center overflow-hidden">
                <svg class="h-20 w-20 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>

            <!-- Content Section -->
            <div class="p-6 flex flex-col justify-between flex-grow">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-3 hover:text-indigo-600 transition-colors">
                        How to Perfect Your Job Search: 10 Essential Tips
                    </h2>
                    
                    <p class="text-sm text-gray-500 mb-4 flex items-center flex-wrap">
                        <span class="inline-flex items-center mr-4">
                            <svg class="h-4 w-4 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            By <span class="font-semibold text-gray-700 ml-1">JobPortal Team</span>
                        </span>
                        <span class="inline-flex items-center">
                            <svg class="h-4 w-4 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Dec 04, 2024
                        </span>
                    </p>

                    <p class="text-gray-600 text-sm">
                        Finding the right job can be challenging in today's competitive market. Discover proven strategies and techniques to accelerate your job search and land your dream position...
                    </p>
                </div>

                <div class="mt-6 flex justify-start pt-4 border-t border-gray-200">
                    <a href="/blog/how-to-perfect-job-search-tips" class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-700 transition-colors">
                        Read More
                        <svg class="h-5 w-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </article>

        <!-- Blog Post 2 -->
        <article class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden flex flex-col h-full">
            <!-- Image Section -->
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 h-48 flex items-center justify-center overflow-hidden">
                <svg class="h-20 w-20 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <!-- Content Section -->
            <div class="p-6 flex flex-col justify-between flex-grow">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-3 hover:text-indigo-600 transition-colors">
                        Top Technology Trends Transforming Hiring in 2024
                    </h2>
                    
                    <p class="text-sm text-gray-500 mb-4 flex items-center flex-wrap">
                        <span class="inline-flex items-center mr-4">
                            <svg class="h-4 w-4 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            By <span class="font-semibold text-gray-700 ml-1">HR Expert</span>
                        </span>
                        <span class="inline-flex items-center">
                            <svg class="h-4 w-4 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Dec 02, 2024
                        </span>
                    </p>

                    <p class="text-gray-600 text-sm">
                        AI-powered recruitment, video interviewing, and skills-based hiring are revolutionizing how companies find talent. Explore the latest innovations reshaping the job market...
                    </p>
                </div>

                <div class="mt-6 flex justify-start pt-4 border-t border-gray-200">
                    <a href="/blog/top-tech-trends-2024" class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-700 transition-colors">
                        Read More
                        <svg class="h-5 w-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </article>

        <!-- Blog Post 3 -->
        <article class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden flex flex-col h-full">
            <!-- Image Section -->
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 h-48 flex items-center justify-center overflow-hidden">
                <svg class="h-20 w-20 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <!-- Content Section -->
            <div class="p-6 flex flex-col justify-between flex-grow">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-3 hover:text-indigo-600 transition-colors">
                        How to Build a Winning Resume
                    </h2>
                    
                    <p class="text-sm text-gray-500 mb-4 flex items-center flex-wrap">
                        <span class="inline-flex items-center mr-4">
                            <svg class="h-4 w-4 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            By <span class="font-semibold text-gray-700 ml-1">Resume Expert</span>
                        </span>
                        <span class="inline-flex items-center">
                            <svg class="h-4 w-4 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Nov 28, 2024
                        </span>
                    </p>

                    <p class="text-gray-600 text-sm">
                        Your resume is your first impression. Learn how to craft a compelling resume that showcases your skills, experience, and achievements in a way that captures recruiters' attention...
                    </p>
                </div>

                <div class="mt-6 flex justify-start pt-4 border-t border-gray-200">
                    <a href="/blog/how-to-build-winning-resume" class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-700 transition-colors">
                        Read More
                        <svg class="h-5 w-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </article>

        <!-- Blog Post 4 -->
        <article class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden flex flex-col h-full">
            <!-- Image Section -->
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 h-48 flex items-center justify-center overflow-hidden">
                <svg class="h-20 w-20 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <!-- Content Section -->
            <div class="p-6 flex flex-col justify-between flex-grow">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-3 hover:text-indigo-600 transition-colors">
                        Negotiating Your Salary Like a Pro
                    </h2>
                    
                    <p class="text-sm text-gray-500 mb-4 flex items-center flex-wrap">
                        <span class="inline-flex items-center mr-4">
                            <svg class="h-4 w-4 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            By <span class="font-semibold text-gray-700 ml-1">Salary Coach</span>
                        </span>
                        <span class="inline-flex items-center">
                            <svg class="h-4 w-4 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Nov 25, 2024
                        </span>
                    </p>

                    <p class="text-gray-600 text-sm">
                        Salary negotiation is a critical skill that can significantly impact your career earnings. Discover proven strategies and tactics to negotiate the best compensation package...
                    </p>
                </div>

                <div class="mt-6 flex justify-start pt-4 border-t border-gray-200">
                    <a href="/blog/negotiating-salary-like-pro" class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-700 transition-colors">
                        Read More
                        <svg class="h-5 w-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </article>

        <!-- Blog Post 5 -->
        <article class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden flex flex-col h-full">
            <!-- Image Section -->
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 h-48 flex items-center justify-center overflow-hidden">
                <svg class="h-20 w-20 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>

            <!-- Content Section -->
            <div class="p-6 flex flex-col justify-between flex-grow">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-3 hover:text-indigo-600 transition-colors">
                        Mastering LinkedIn for Career Success
                    </h2>
                    
                    <p class="text-sm text-gray-500 mb-4 flex items-center flex-wrap">
                        <span class="inline-flex items-center mr-4">
                            <svg class="h-4 w-4 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            By <span class="font-semibold text-gray-700 ml-1">Social Media Strategist</span>
                        </span>
                        <span class="inline-flex items-center">
                            <svg class="h-4 w-4 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Nov 22, 2024
                        </span>
                    </p>

                    <p class="text-gray-600 text-sm">
                        LinkedIn is the world's largest professional network. Learn how to optimize your profile, build meaningful connections, and attract top recruiters and employers...
                    </p>
                </div>

                <div class="mt-6 flex justify-start pt-4 border-t border-gray-200">
                    <a href="/blog/mastering-linkedin-career-success" class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-700 transition-colors">
                        Read More
                        <svg class="h-5 w-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </article>

        <!-- Blog Post 6 -->
        <article class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden flex flex-col h-full">
            <!-- Image Section -->
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 h-48 flex items-center justify-center overflow-hidden">
                <svg class="h-20 w-20 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>

            <!-- Content Section -->
            <div class="p-6 flex flex-col justify-between flex-grow">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-3 hover:text-indigo-600 transition-colors">
                        Remote Work: Benefits and Best Practices
                    </h2>
                    
                    <p class="text-sm text-gray-500 mb-4 flex items-center flex-wrap">
                        <span class="inline-flex items-center mr-4">
                            <svg class="h-4 w-4 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            By <span class="font-semibold text-gray-700 ml-1">Work Culture Expert</span>
                        </span>
                        <span class="inline-flex items-center">
                            <svg class="h-4 w-4 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Nov 20, 2024
                        </span>
                    </p>

                    <p class="text-gray-600 text-sm">
                        Remote work has become the new normal. Explore the benefits of working from home and discover best practices to stay productive, engaged, and connected with your team...
                    </p>
                </div>

                <div class="mt-6 flex justify-start pt-4 border-t border-gray-200">
                    <a href="/blog/remote-work-benefits-best-practices" class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-700 transition-colors">
                        Read More
                        <svg class="h-5 w-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </article>
    </div>
</div>

<!-- Newsletter Section -->
<div class="bg-indigo-50 py-16 mt-16">
    <div class="max-w-2xl mx-auto text-center px-4">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Stay Updated with Latest News</h2>
        <p class="text-lg text-gray-600 mb-8">Subscribe to get job tips and industry news delivered directly to your email.</p>
        <form class="flex flex-col sm:flex-row gap-3">
            <input type="email" placeholder="Enter your email" required class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-600">
            <button type="submit" class="px-8 py-3 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition-colors">
                Subscribe
            </button>
        </form>
    </div>
</div>
@endsection

