@extends('layouts.public')

@section('content')
    <!-- Hero Section -->
    <section class="bg-linear-to-br from-primary-50 to-secondary-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                    Find Your Dream <span class="text-primary-600">Job</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Connect with top employers and discover opportunities that match your skills and aspirations.
                    J-Hub makes job hunting simple, efficient, and rewarding.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <x-ui.button variant="primary" size="lg" href="{{ route('register.jobseeker.show') }}">
                        Get Started as Job Seeker
                    </x-ui.button>
                    <x-ui.button variant="secondary" size="lg" href="{{ route('register.employer.show') }}">
                        Post a Job as Employer
                    </x-ui.button>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Jobs Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Featured Jobs</h2>
                <p class="text-lg text-gray-600">Discover the latest opportunities from top companies</p>
            </div>

            @if ($featuredJobs->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach ($featuredJobs as $job)
                        <x-job.job-card :job="$job" />
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 0V8a2 2 0 01-2 2H8a2 2 0 01-2-2V6m8 0H8m0 0V4">
                        </path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No jobs available yet</h3>
                    <p class="text-gray-500 mb-6">Check back soon for new opportunities!</p>
                    <x-ui.button variant="primary" href="{{ route('register.employer.show') }}">
                        Be the first to post a job
                    </x-ui.button>
                </div>
            @endif

            <div class="text-center">
                <x-ui.button variant="ghost" href="{{ route('jobs.index') }}"
                    class="text-primary-600 hover:text-primary-700">
                    View All Jobs →
                </x-ui.button>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold text-primary-600 mb-2">1,000+</div>
                    <div class="text-gray-600">Active Jobs</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-primary-600 mb-2">500+</div>
                    <div class="text-gray-600">Companies</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-primary-600 mb-2">10,000+</div>
                    <div class="text-gray-600">Job Seekers</div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">How J-Hub Works</h2>
                <p class="text-lg text-gray-600">Simple steps to connect talent with opportunity</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Create Your Profile</h3>
                    <p class="text-gray-600">Sign up as a job seeker or employer and build your professional profile.</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Find or Post Jobs</h3>
                    <p class="text-gray-600">Browse opportunities or post positions that match your requirements.</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Connect & Succeed</h3>
                    <p class="text-gray-600">Apply to jobs or review applications to find the perfect match.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-primary-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Ready to Get Started?</h2>
            <p class="text-xl text-primary-100 mb-8">
                Join thousands of professionals who have found their perfect career match on J-Hub.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <x-ui.button variant="secondary" size="lg" href="{{ route('register.jobseeker.show') }}">
                    Start Your Job Search
                </x-ui.button>
                <x-ui.button variant="outline" size="lg" href="{{ route('register.employer.show') }}"
                    class="border-white text-white hover:bg-white hover:text-primary-600">
                    Hire Top Talent
                </x-ui.button>
            </div>
        </div>
    </section>
@endsection
