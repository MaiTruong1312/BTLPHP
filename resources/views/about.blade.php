@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    About Our Job Portal
                </h2>
                <p class="mt-4 text-lg text-gray-500">
                    Connecting talent with opportunity.
                </p>
            </div>

            <div class="mt-10 prose prose-lg text-gray-500 mx-auto">
                <p>
                    Welcome to our job portal, the premier destination for job seekers and employers. Our mission is to bridge the gap between talented professionals and the companies that need them. We believe that finding the right job should be a seamless and rewarding experience.
                </p>
                <p>
                    Our platform offers a comprehensive database of job listings across various industries. For job seekers, we provide tools to create detailed profiles, upload resumes, and apply for jobs with ease. For employers, we offer a streamlined process to post job openings, manage applications, and find the perfect candidates.
                </p>
                <p>
                    We are committed to creating a transparent and efficient marketplace for employment. Our team is passionate about leveraging technology to empower both individuals and businesses. Thank you for choosing our platform for your career and hiring needs.
                </p>

                <div class="mt-8 text-center">
                    <h3 class="text-2xl font-bold text-gray-900">Our Values</h3>
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="p-6 bg-gray-50 rounded-lg">
                            <h4 class="text-xl font-semibold text-gray-800">Integrity</h4>
                            <p class="mt-2 text-base text-gray-600">
                                We operate with honesty and transparency in all our interactions.
                            </p>
                        </div>
                        <div class="p-6 bg-gray-50 rounded-lg">
                            <h4 class="text-xl font-semibold text-gray-800">Innovation</h4>
                            <p class="mt-2 text-base text-gray-600">
                                We continuously seek to improve and innovate our platform for a better user experience.
                            </p>
                        </div>
                        <div class="p-6 bg-gray-50 rounded-lg">
                            <h4 class="text-xl font-semibold text-gray-800">Community</h4>
                            <p class="mt-2 text-base text-gray-600">
                                We are dedicated to building a supportive community for professionals and companies.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
