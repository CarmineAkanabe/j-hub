@extends('layouts.auth')

@section('sidebar')
    @include('components.sidebar.employer-sidebar')
@endsection

@section('content')
    <div class="space-y-8">
        @if (session('success'))
            <x-ui.alert type="success" class="max-w-3xl">
                {{ session('success') }}
            </x-ui.alert>
        @endif

        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Employer dashboard</h1>
                    <p class="mt-2 text-sm text-slate-600">Manage your job posts, view applications, and stay on top of
                        hiring.</p>
                </div>
                <x-ui.button href="{{ route('employer.jobs.create') }}" variant="primary" size="lg">
                    Post a New Job
                </x-ui.button>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Open Jobs</p>
                    <p class="mt-4 text-4xl font-bold text-slate-900">{{ $jobCount }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Applications Received</p>
                    <p class="mt-4 text-4xl font-bold text-slate-900">{{ $applicationsCount }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Recent Jobs</p>
                    <p class="mt-4 text-4xl font-bold text-slate-900">{{ $recentJobs->count() }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-slate-900">Hiring Activity</h2>
                    <p class="mt-1 text-sm text-slate-600">A quick comparison of your posted jobs and received applications.</p>
                </div>
            </div>

            <div class="mt-8 space-y-5">
                @foreach ($chartData as $item)
                    <div>
                        <div class="mb-2 flex items-center justify-between gap-4">
                            <span class="text-sm font-medium text-slate-700">{{ $item['label'] }}</span>
                            <span class="text-sm font-semibold text-slate-900">{{ number_format($item['value']) }}</span>
                        </div>
                        <div class="h-4 overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-primary transition-all" style="width: {{ $item['width'] }}%">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-semibold text-slate-900">Recent Job Posts</h2>
                    <p class="mt-1 text-sm text-slate-600">Quick access to your latest posted roles.</p>
                </div>
                <x-ui.button href="{{ route('employer.jobs.index') }}" variant="secondary">View All Jobs</x-ui.button>
            </div>

            <div class="mt-8 space-y-4">
                @forelse($recentJobs as $job)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">{{ $job->title }}</h3>
                                <p class="text-sm text-slate-600">{{ $job->location }} · {{ ucfirst($job->status->value) }}
                                </p>
                            </div>
                            <span
                                class="rounded-full bg-primary-100 px-3 py-2 text-sm text-primary-700">{{ $job->applications_count }}
                                applications</span>
                        </div>
                    </div>
                @empty
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6 text-center">
                        <p class="text-slate-600">No jobs posted yet. Create your first role to start receiving
                            applications.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
