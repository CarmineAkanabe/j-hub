@extends('layouts.public')

@section('title', 'About Us')

@section('content')
    <div class="mx-auto max-w-6xl space-y-10 py-10">
        <section class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="grid gap-8 lg:grid-cols-[1.5fr_1fr]">
                <div>
                    <h1 class="text-4xl font-bold text-slate-900">About J-Hub</h1>
                    <p class="mt-4 text-lg text-slate-600 leading-8">J-Hub is a clean, role-based Laravel job portal built to
                        connect employers and job seekers with a simple, reliable workflow. Employers can post jobs, review
                        applicants, and send decisions. Job seekers can discover roles, apply with a single click, and
                        communicate through role-specific notifications and comments.</p>
                    <p class="mt-4 text-lg text-slate-600 leading-8">This system is designed to stay lightweight, intuitive,
                        and professional, while preserving the essential features for a modern hiring platform.</p>
                </div>
                <div class="rounded-3xl bg-slate-950 p-8 text-white">
                    <h2 class="text-xl font-semibold">What you get</h2>
                    <ul class="mt-6 space-y-4 text-sm text-slate-200">
                        <li class="flex gap-3"><span
                                class="mt-1 inline-flex h-2.5 w-2.5 rounded-full bg-primary-600"></span>Role-based employer,
                            job seeker, and admin access</li>
                        <li class="flex gap-3"><span
                                class="mt-1 inline-flex h-2.5 w-2.5 rounded-full bg-primary-600"></span>Job listings,
                            applications, decisions, and notifications</li>
                        <li class="flex gap-3"><span
                                class="mt-1 inline-flex h-2.5 w-2.5 rounded-full bg-primary-600"></span>Profile management
                            and clean admin oversight</li>
                        <li class="flex gap-3"><span
                                class="mt-1 inline-flex h-2.5 w-2.5 rounded-full bg-primary-600"></span>Modern Tailwind
                            styling with a minimal interface</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="space-y-6">
            <div>
                <h2 class="text-3xl font-bold text-slate-900">Team</h2>
                <p class="mt-3 text-slate-600">A small development team responsible for bringing J-Hub to life.</p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-slate-900">Abanda Ambrouise</h3>
                            <p class="text-sm text-slate-500">Backend & Platform</p>
                        </div>
                    </div>
                    <p class="mt-5 text-sm leading-7 text-slate-600">Contributor focused on the underlying Laravel
                        architecture, application flows, and system stability.</p>
                    <a href="https://github.com/AmbroiseAB" target="_blank"
                        class="mt-5 inline-flex text-sm font-semibold text-primary-600 hover:text-primary-700">github.com/AmbroiseAB</a>
                </article>

                <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-slate-900">Serge</h3>
                            <p class="text-sm text-slate-500">Product Owner</p>
                        </div>
                    </div>
                    <p class="mt-5 text-sm leading-7 text-slate-600">Project lead responsible for vision, user experience,
                        and ensuring the application delivers a polished result.</p>
                    <a href="https://github.com/CarmineAkanabe" target="_blank"
                        class="mt-5 inline-flex text-sm font-semibold text-primary-600 hover:text-primary-700">github.com/CarmineAkanabe</a>
                </article>

                <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-slate-900">Christine</h3>
                            <p class="text-sm text-slate-500">UI & Content</p>
                        </div>
                    </div>
                    <p class="mt-5 text-sm leading-7 text-slate-600">Supports the user interface, content presentation, and
                        overall design consistency across pages.</p>
                    <a href="https://github.com/Krystyna21" target="_blank"
                        class="mt-5 inline-flex text-sm font-semibold text-primary-600 hover:text-primary-700">github.com/Krystyna21</a>
                </article>

                <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-slate-900">Herbet</h3>
                            <p class="text-sm text-slate-500">QA & Support</p>
                        </div>
                    </div>
                    <p class="mt-5 text-sm leading-7 text-slate-600">Ensures the platform runs reliably and helps keep the
                        application ready for real-world use.</p>
                    <a href="https://github.com/NkengH" target="_blank"
                        class="mt-5 inline-flex text-sm font-semibold text-primary-600 hover:text-primary-700">github.com/NkengH</a>
                </article>

                <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-slate-900">Samuel</h3>
                            <p class="text-sm text-slate-500">Operations</p>
                        </div>
                    </div>
                    <p class="mt-5 text-sm leading-7 text-slate-600">Helps shape the product roadmap and ensures the
                        platform supports practical team workflows.</p>
                    <a href="https://github.com/Nsan-237" target="_blank"
                        class="mt-5 inline-flex text-sm font-semibold text-primary-600 hover:text-primary-700">github.com/Nsan-237</a>
                </article>

                <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-slate-900">Mecula</h3>
                            <p class="text-sm text-slate-500">Infrastructure</p>
                        </div>
                    </div>
                    <p class="mt-5 text-sm leading-7 text-slate-600">Maintains the deployment readiness and assists with
                        platform reliability and performance.</p>
                    <a href="https://github.com/Dankun3" target="_blank"
                        class="mt-5 inline-flex text-sm font-semibold text-primary-600 hover:text-primary-700">github.com/Dankun3</a>
                </article>
            </div>
        </section>
    </div>
@endsection
