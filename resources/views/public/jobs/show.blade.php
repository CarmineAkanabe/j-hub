@extends('layouts.public')

@section('content')
    <section class="space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">{{ $job->title }}</h1>
                <p class="text-sm text-slate-500">{{ $job->employer->company_name ?? ($job->employer->name ?? 'Employer') }}
                    ·
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

        @if (session('success'))
            <div class="mt-6">
                <x-ui.alert type="success">{{ session('success') }}</x-ui.alert>
            </div>
        @endif

        @if (session('error'))
            <div class="mt-6">
                <x-ui.alert type="error">{{ session('error') }}</x-ui.alert>
            </div>
        @endif

        <div class="grid gap-8 lg:grid-cols-[1fr_280px]">
            <article class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="prose prose-slate max-w-none">
                    {!! nl2br(e($job->description)) !!}
                </div>

                <div class="mt-10">
                    <div class="flex items-center justify-between gap-4">
                        <h2 class="text-xl font-semibold text-slate-900">Comments</h2>
                        <span
                            class="rounded-full bg-slate-100 px-3 py-1 text-sm text-slate-700">{{ $job->comments->count() }}
                            comments</span>
                    </div>

                    <div class="mt-6 space-y-4">
                        @forelse($job->comments as $comment)
                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-sm text-slate-500">{{ $comment->user->name }} ·
                                    {{ $comment->date->format('M d, Y') }}</p>
                                <p class="mt-2 text-slate-700">{{ $comment->content }}</p>
                            </div>
                        @empty
                            <div class="rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-6 text-slate-600">
                                No comments yet. Job seekers can add the first comment below.
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8 rounded-3xl border border-slate-200 bg-slate-50 p-6">
                        <h3 class="text-lg font-semibold text-slate-900">Leave a comment</h3>
                        @if (auth()->check() && auth()->user()->isJobSeeker())
                            <form method="POST" action="{{ route('comments.store', $job) }}" class="mt-4 space-y-4">
                                @csrf
                                <textarea name="content" rows="4"
                                    class="w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900"
                                    placeholder="Share a comment with the employer...">{{ old('content') }}</textarea>
                                @error('content')
                                    <p class="text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                                <div class="flex justify-end">
                                    <x-ui.button type="submit" variant="primary">Post comment</x-ui.button>
                                </div>
                            </form>
                        @elseif(auth()->check())
                            <p class="mt-4 text-sm text-slate-600">Only job seekers can leave comments on jobs.</p>
                        @else
                            <p class="mt-4 text-sm text-slate-600">Please log in as a job seeker to comment on this job.</p>
                            <div class="mt-4 flex flex-col gap-3 sm:flex-row">
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center justify-center rounded-full bg-primary-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-primary-700">Login</a>
                                <a href="{{ route('register.jobseeker.show') }}"
                                    class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-100">Register</a>
                            </div>
                        @endif
                    </div>
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
                    @if (auth()->check() && auth()->user()->isJobSeeker())
                        @if (isset($userApplication) && $userApplication)
                            <p class="text-sm text-slate-600 mb-4">You have already applied for this role.</p>
                            <div class="rounded-3xl bg-slate-100 p-4 text-sm text-slate-700">
                                <p>Status: <strong>{{ ucfirst($userApplication->status->value) }}</strong></p>
                                <p class="mt-2">Applied on {{ $userApplication->date->format('M d, Y') }}.</p>
                            </div>
                        @else
                            <p class="text-sm text-slate-600 mb-4">Ready to apply? Submit your application below.</p>
                            <form method="POST" action="{{ route('jobs.apply', $job) }}">
                                @csrf
                                <x-ui.button type="submit" variant="primary">Apply for this job</x-ui.button>
                            </form>
                        @endif
                    @elseif(auth()->check())
                        <p class="text-sm text-slate-600 mb-4">Only job seekers can apply for positions. Please switch to a
                            job seeker account.</p>
                    @else
                        <p class="text-sm text-slate-600 mb-4">To apply for this role, please log in or register as a job
                            seeker.</p>
                        <div class="flex flex-col gap-3 sm:flex-row">
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center justify-center rounded-full bg-primary-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-primary-700">Login</a>
                            <a href="{{ route('register.jobseeker.show') }}"
                                class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-100">Register</a>
                        </div>
                    @endif
                </div>
            </aside>
        </div>
    </section>
@endsection
