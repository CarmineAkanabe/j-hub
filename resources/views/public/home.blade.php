@extends('layouts.public')

@section('content')
    <section x-data="{ active: 0, slides: 4 }" x-init="setInterval(() => active = (active + 1) % slides, 6500)"
        class="relative left-1/2 min-h-[680px] w-screen -translate-x-1/2 overflow-hidden bg-slate-950">
        <div class="absolute inset-0">
            <img x-show="active === 0" x-transition.opacity.duration.1000ms src="{{ asset('images/home/interview-office.jpg') }}"
                alt="Candidate speaking with a recruiter in a bright office"
                class="absolute inset-0 h-full w-full object-cover opacity-65">
            <img x-cloak x-show="active === 1" x-transition.opacity.duration.1000ms src="{{ asset('images/home/candidate-review.jpg') }}"
                alt="Hiring manager reviewing candidate documents"
                class="absolute inset-0 h-full w-full object-cover opacity-65">
            <img x-cloak x-show="active === 2" x-transition.opacity.duration.1000ms src="{{ asset('images/home/remote-interview.jpg') }}"
                alt="Team conducting a remote job interview"
                class="absolute inset-0 h-full w-full object-cover opacity-65">
            <img x-cloak x-show="active === 3" x-transition.opacity.duration.1000ms src="{{ asset('images/home/offer-handshake.jpg') }}"
                alt="Professional handshake after a successful interview"
                class="absolute inset-0 h-full w-full object-cover opacity-65">
            <div class="absolute inset-0 bg-slate-950/70"></div>
            <div class="absolute inset-0 bg-linear-to-r from-slate-950 via-slate-950/70 to-slate-950/20"></div>
        </div>

        <div class="relative mx-auto flex min-h-[680px] max-w-7xl items-center px-4 py-24 sm:px-6 lg:px-8">
            <div class="max-w-3xl text-white">
                <p class="mb-5 inline-flex rounded-full border border-white/25 bg-white/10 px-4 py-2 text-sm font-semibold">
                    Jobs, applicants, comments, and status updates in one place
                </p>
                <h1 class="font-heading text-5xl font-extrabold leading-tight md:text-7xl">
                    J-Hub connects careers with teams ready to hire.
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-200 md:text-xl">
                    Browse open roles, apply with confidence, and keep every application conversation moving inside a
                    clean Laravel-powered job portal.
                </p>

                <form method="GET" action="{{ route('jobs.index') }}"
                    class="mt-8 grid gap-3 rounded-3xl border border-white/15 bg-white/95 p-3 shadow-2xl sm:grid-cols-[1fr_1fr_auto]">
                    <input name="search" type="search" placeholder="Job title or keyword"
                        class="min-h-12 rounded-2xl border border-slate-200 px-4 text-sm text-slate-900 outline-none focus:border-slate-900">
                    <input name="location" type="search" placeholder="Location"
                        class="min-h-12 rounded-2xl border border-slate-200 px-4 text-sm text-slate-900 outline-none focus:border-slate-900">
                    <x-ui.button type="submit" variant="primary" size="lg">Search Jobs</x-ui.button>
                </form>

                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                    <x-ui.button variant="secondary" size="lg" href="{{ route('register.jobseeker.show') }}">
                        Start as Job Seeker
                    </x-ui.button>
                    <x-ui.button variant="outline" size="lg" href="{{ route('register.employer.show') }}"
                        class="border-white/60 bg-white/10 text-white hover:bg-white hover:text-slate-900">
                        Hire Talent
                    </x-ui.button>
                </div>
            </div>
        </div>
    </section>

    <section class="relative left-1/2 w-screen -translate-x-1/2 bg-white py-10">
        <div class="mx-auto grid max-w-7xl gap-4 px-4 sm:grid-cols-3 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                <p class="text-3xl font-bold text-slate-900">{{ number_format($stats['openJobs']) }}</p>
                <p class="mt-1 text-sm text-slate-600">Open jobs available now</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                <p class="text-3xl font-bold text-slate-900">{{ number_format($stats['employers']) }}</p>
                <p class="mt-1 text-sm text-slate-600">Employers posting roles</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                <p class="text-3xl font-bold text-slate-900">{{ number_format($stats['applications']) }}</p>
                <p class="mt-1 text-sm text-slate-600">Applications tracked</p>
            </div>
        </div>
    </section>

    <section class="relative left-1/2 w-screen -translate-x-1/2 bg-slate-50 py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-primary">Featured roles</p>
                    <h2 class="mt-3 text-3xl font-bold text-slate-900 md:text-4xl">Fresh opportunities from active employers</h2>
                </div>
                <x-ui.button variant="secondary" href="{{ route('jobs.index') }}">View All Jobs</x-ui.button>
            </div>

            @if ($featuredJobs->count() > 0)
                <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($featuredJobs as $job)
                        <x-job.job-card :job="$job" />
                    @endforeach
                </div>
            @else
                <div class="mt-10 rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center">
                    <h3 class="text-lg font-semibold text-slate-900">No jobs available yet</h3>
                    <p class="mt-2 text-slate-600">New opportunities will appear here as employers publish them.</p>
                    <div class="mt-6">
                        <x-ui.button variant="primary" href="{{ route('register.employer.show') }}">
                            Be the first to post a job
                        </x-ui.button>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <section class="relative left-1/2 w-screen -translate-x-1/2 bg-white py-20">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-8">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-primary">Built for both sides</p>
                <h2 class="mt-3 text-3xl font-bold text-slate-900 md:text-4xl">A focused workflow from listing to decision</h2>
                <p class="mt-5 text-lg leading-8 text-slate-600">
                    Job seekers get a clear place to apply, comment, and track progress. Employers get a simple dashboard
                    for postings, applicants, and notifications when candidates interact with their roles.
                </p>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm font-semibold text-primary">For job seekers</p>
                    <h3 class="mt-3 text-xl font-bold text-slate-900">Apply and follow every response</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-600">
                        Search jobs, submit applications, manage comments, and see status changes as they happen.
                    </p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm font-semibold text-primary">For employers</p>
                    <h3 class="mt-3 text-xl font-bold text-slate-900">Review candidates without losing context</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-600">
                        Publish jobs, inspect applicants, accept or refuse applications, and receive activity updates.
                    </p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm font-semibold text-primary">For admins</p>
                    <h3 class="mt-3 text-xl font-bold text-slate-900">Keep the platform accountable</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-600">
                        Monitor users, review activity, and handle account cleanup from one protected area.
                    </p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-950 p-6 text-white">
                    <p class="text-sm font-semibold text-emerald-300">Simple by design</p>
                    <h3 class="mt-3 text-xl font-bold">Laravel, Blade, Tailwind</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-300">
                        The interface stays straightforward while the core portal features stay easy to extend.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="relative left-1/2 w-screen -translate-x-1/2 bg-slate-950 py-20">
        <div class="absolute inset-0">
            <img src="{{ asset('images/home/offer-handshake.jpg') }}" alt="Successful hiring handshake"
                class="h-full w-full object-cover opacity-30">
            <div class="absolute inset-0 bg-slate-950/70"></div>
        </div>

        <div class="relative mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-white md:text-5xl">Ready to move from browsing to hiring?</h2>
            <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-200">
                Create an account, publish a role, or start applying to the jobs already waiting inside J-Hub.
            </p>
            <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                <x-ui.button variant="secondary" size="lg" href="{{ route('register.jobseeker.show') }}">
                    Find My Next Role
                </x-ui.button>
                <x-ui.button variant="outline" size="lg" href="{{ route('register.employer.show') }}"
                    class="border-white/60 bg-white/10 text-white hover:bg-white hover:text-slate-900">
                    Post a Job
                </x-ui.button>
            </div>
        </div>
    </section>
@endsection
