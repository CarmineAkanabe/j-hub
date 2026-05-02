@extends('layouts.auth')

@section('sidebar')
    @include('components.sidebar.admin-sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Admin Dashboard</h1>
                    <p class="mt-2 text-sm text-slate-600">Monitor users, site activity, and platform health.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <x-ui.button href="{{ route('admin.users.index') }}" variant="secondary">Manage Users</x-ui.button>
                    <x-ui.button href="{{ route('admin.logs.index') }}" variant="secondary">View Logs</x-ui.button>
                </div>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Users</p>
                    <p class="mt-4 text-4xl font-bold text-slate-900">{{ $userCount }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Jobs</p>
                    <p class="mt-4 text-4xl font-bold text-slate-900">{{ $jobCount }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Applications</p>
                    <p class="mt-4 text-4xl font-bold text-slate-900">{{ $applicationCount }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Comments</p>
                    <p class="mt-4 text-4xl font-bold text-slate-900">{{ $commentCount }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div>
                <h2 class="text-2xl font-semibold text-slate-900">Account Mix</h2>
                <p class="mt-1 text-sm text-slate-600">Employer and job seeker distribution across the platform.</p>
            </div>

            <div class="mt-8 space-y-5">
                @foreach ($roleChartData as $item)
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
    </div>
@endsection
