@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-96 flex items-center justify-center text-center">
        <div>
            <h1 class="text-5xl font-extrabold mb-4">About JobPortal</h1>
            <p class="text-xl text-indigo-100">Connecting Talent with Opportunity</p>
        </div>
    </div>
</div>

<!-- Main Content -->
<main class="bg-white">
    <!-- Mission Section -->
    <section class="py-16 lg:py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-indigo-50 rounded-xl p-8 lg:p-12 border-l-4 border-indigo-600">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">Our Mission</h2>
                <p class="text-lg text-gray-700 leading-relaxed">
                    At JobPortal, we believe that finding the right job—or the right candidate—should be straightforward, transparent, and rewarding. Our mission is to bridge the gap between talented professionals and innovative companies, creating meaningful career connections that benefit everyone.
                </p>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-16 lg:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-12 text-center">Why Choose JobPortal?</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-lg p-8 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex gap-5">
                        <div class="flex-shrink-0">
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Advanced Tools</h3>
                            <p class="text-gray-600">Powerful search filters, resume builders, and application tracking to succeed in your career.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-lg p-8 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex gap-5">
                        <div class="flex-shrink-0">
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM4 20h16a2 2 0 002-2v-2a3 3 0 00-3-3H5a3 3 0 00-3 3v2a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Diverse Opportunities</h3>
                            <p class="text-gray-600">Access thousands of positions across every industry and location. Find your perfect fit.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-lg p-8 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex gap-5">
                        <div class="flex-shrink-0">
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Trusted & Secure</h3>
                            <p class="text-gray-600">Your data security is our priority with industry-leading encryption and privacy practices.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white rounded-lg p-8 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex gap-5">
                        <div class="flex-shrink-0">
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Career Development</h3>
                            <p class="text-gray-600">Expert advice on career growth, interviews, salary negotiation, and industry insights.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-12 text-center">Our Core Values</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg p-8 shadow-sm hover:shadow-md transition-shadow border-t-4 border-indigo-600">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Integrity</h3>
                    <p class="text-gray-600">We operate with honesty and transparency in every interaction. Your trust is our foundation.</p>
                </div>

                <div class="bg-white rounded-lg p-8 shadow-sm hover:shadow-md transition-shadow border-t-4 border-indigo-600">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Innovation</h3>
                    <p class="text-gray-600">We constantly evolve with cutting-edge technology to serve you better every day.</p>
                </div>

                <div class="bg-white rounded-lg p-8 shadow-sm hover:shadow-md transition-shadow border-t-4 border-indigo-600">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Community</h3>
                    <p class="text-gray-600">We build a supportive ecosystem where professionals and employers grow together.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-16 lg:py-20 bg-gradient-to-r from-indigo-600 to-indigo-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl lg:text-4xl font-bold text-white mb-12 text-center">By The Numbers</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-4xl lg:text-5xl font-bold text-indigo-200 mb-2">50K+</div>
                    <p class="text-indigo-100 text-lg">Active Job Listings</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl lg:text-5xl font-bold text-indigo-200 mb-2">200K+</div>
                    <p class="text-indigo-100 text-lg">Registered Users</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl lg:text-5xl font-bold text-indigo-200 mb-2">500+</div>
                    <p class="text-indigo-100 text-lg">Partner Companies</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl lg:text-5xl font-bold text-indigo-200 mb-2">10K+</div>
                    <p class="text-indigo-100 text-lg">Successful Placements</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-16 lg:py-20 bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Ready to Get Started?</h2>
            <p class="text-lg text-gray-600 mb-8">Join thousands of professionals finding their next opportunity.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('jobs.index') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition-colors">
                    Browse Jobs
                    <svg class="h-5 w-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-lg bg-white border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition-colors">
                    Create Account
                </a>
            </div>
        </div>
    </section>
</main>
@endsection
