@extends('layouts.public')

@section('title', 'About Us')

@section('content')
    @php
        $team = [
            [
                'name' => 'Abanda Ambrouise',
                'role' => 'Product Owner',
                'description' => 'Project lead responsible for vision, user experience, and ensuring the application delivers a polished result.',
                'github' => 'https://github.com/AmbroiseAB',
                'initials' => 'AA',
            ],
            [
                'name' => 'Serge',
                'role' => 'Backend & Platform',
                'description' => 'Contributor focused on the underlying Laravel architecture, application flows, and system stability.',
                'github' => 'https://github.com/CarmineAkanabe',
                'initials' => 'S',
            ],
            [
                'name' => 'Christine',
                'role' => 'UI & Content',
                'description' => 'Supports the user interface, content presentation, and overall design consistency across pages.',
                'github' => 'https://github.com/Krystyna21',
                'initials' => 'C',
            ],
            [
                'name' => 'Herbet',
                'role' => 'QA & Support',
                'description' => 'Ensures the platform runs reliably and helps keep the application ready for real-world use.',
                'github' => 'https://github.com/NkengH',
                'initials' => 'H',
            ],
            [
                'name' => 'Samuel',
                'role' => 'Operations',
                'description' => 'Helps shape the product roadmap and ensures the platform supports practical team workflows.',
                'github' => 'https://github.com/Nsan-237',
                'initials' => 'S',
            ],
            [
                'name' => 'Mekoula',
                'role' => 'Infrastructure',
                'description' => 'Maintains the deployment readiness and assists with platform reliability and performance.',
                'github' => 'https://github.com/Dankun3',
                'initials' => 'M',
            ],
        ];
    @endphp

    <div class="space-y-16 py-8">
        <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="grid lg:grid-cols-[1.05fr_0.95fr]">
                <div class="p-8 sm:p-10 lg:p-12">
                    <p class="text-sm font-semibold uppercase tracking-wide text-primary">About J-Hub</p>
                    <h1 class="mt-4 max-w-3xl text-4xl font-bold leading-tight text-slate-900 md:text-5xl">
                        A focused hiring portal for employers, job seekers, and admins.
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-slate-600">
                        J-Hub is a clean, role-based Laravel job portal built to connect employers and job seekers with a
                        simple, reliable workflow. Employers can post jobs, review applicants, and send decisions. Job
                        seekers can discover roles, apply with a single click, and communicate through role-specific
                        notifications and comments.
                    </p>
                    <p class="mt-4 text-lg leading-8 text-slate-600">
                        This system is designed to stay lightweight, intuitive, and professional, while preserving the
                        essential features for a modern hiring platform.
                    </p>
                </div>

                <div class="relative min-h-[360px] bg-slate-950">
                    <img src="{{ asset('images/home/remote-interview.jpg') }}" alt="Team reviewing candidates remotely"
                        class="absolute inset-0 h-full w-full object-cover opacity-60">
                    <div class="absolute inset-0 bg-slate-950/55"></div>
                    <div class="relative flex h-full items-end p-8 sm:p-10">
                        <div class="rounded-3xl border border-white/15 bg-white/10 p-6 text-white backdrop-blur-sm">
                            <p class="text-sm font-semibold text-emerald-300">Built with Laravel, Blade, and Tailwind</p>
                            <p class="mt-3 text-2xl font-bold">Clear workflows. Practical features. A professional finish.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-6 md:grid-cols-3">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-primary">Access</p>
                <h2 class="mt-3 text-xl font-bold text-slate-900">Role-based areas</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">
                    Separate experiences for employers, job seekers, and administrators keep every workflow focused.
                </p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-primary">Hiring</p>
                <h2 class="mt-3 text-xl font-bold text-slate-900">Listings to decisions</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">
                    Jobs, applications, comments, notifications, and applicant decisions live in one straightforward app.
                </p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-primary">Oversight</p>
                <h2 class="mt-3 text-xl font-bold text-slate-900">Admin visibility</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">
                    Admin tools provide account review, platform metrics, and log access for responsible supervision.
                </p>
            </div>
        </section>

        <section class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm sm:p-10">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-primary">Project team</p>
                    <h2 class="mt-3 text-3xl font-bold text-slate-900">The people behind J-Hub</h2>
                    <p class="mt-3 max-w-2xl text-slate-600">
                        A small development team responsible for bringing J-Hub to life.
                    </p>
                </div>
            </div>

            <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($team as $member)
                    <article class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                        <div class="flex items-center gap-4">
                            <div
                                class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-slate-950 text-sm font-bold text-white">
                                {{ $member['initials'] }}
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-slate-900">{{ $member['name'] }}</h3>
                                <p class="text-sm text-slate-500">{{ $member['role'] }}</p>
                            </div>
                        </div>
                        <p class="mt-5 text-sm leading-7 text-slate-600">{{ $member['description'] }}</p>
                        <a href="{{ $member['github'] }}" target="_blank" rel="noreferrer"
                            class="mt-5 inline-flex text-sm font-semibold text-primary hover:text-primary-hover">
                            {{ \Illuminate\Support\Str::after($member['github'], 'https://') }}
                        </a>
                    </article>
                @endforeach
            </div>
        </section>
    </div>
@endsection
