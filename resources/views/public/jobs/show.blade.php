@extends('layouts.public')

@section('content')
    <section class="space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">{{ $job->title }}</h1>
                <p class="text-sm text-slate-500">{{ $job->employer->company_name ?? ($job->employer->name ?? 'Employer') }} ·
                    {{ $job->location }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <x-ui.badge variant="success">{{ ucfirst(optional($job->status)->value ?? $job->status) }}</x-ui.badge>
                @if ($job->expected_salary)
                    <span
                        class="rounded-full bg-slate-100 px-3 py-2 text-sm text-slate-700">${{ number_format($job->expected_salary) }}</span>
                @endif
            </div>
        </div>

        <div class="grid gap-8 lg:grid-cols-[1fr_280px]">
            <article class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="prose prose-slate max-w-none">
                    {!! nl2br(e($job->description)) !!}
                </div>
            </article>

            <aside class="space-y-6 rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 mb-3">Quick Details</h2>
                    <ul class="space-y-3 text-sm text-slate-600">
                        <li><strong class="text-slate-800">Location:</strong> {{ $job->location }}</li>
                        <li><strong class="text-slate-800">Posted:</strong> {{ $job->created_at->diffForHumans() }}</li>
                        <li><strong class="text-slate-800">Company:</strong>
                            {{ $job->employer->company_name ?? ($job->employer->name ?? 'Unknown') }}</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-slate-900 mb-3">Next Step</h2>
                    <p class="text-sm text-slate-600 mb-4">To apply for this role, please log in or register as a job
                        seeker.</p>
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center justify-center rounded-full bg-primary-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-primary-700">Login</a>
                        <a href="{{ route('register.jobseeker.show') }}"
                            class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-100">Register</a>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
