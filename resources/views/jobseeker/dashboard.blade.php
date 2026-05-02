@extends('layouts.auth')

@section('sidebar')
    @include('components.sidebar.jobseeker-sidebar')
@endsection

@section('content')
    <div class="space-y-8">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <h1 class="text-3xl font-bold text-slate-900">Job Seeker dashboard</h1>
            <p class="mt-2 text-sm text-slate-600">Track your applications and stay informed about new opportunities.</p>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Submitted Applications</p>
                    <p class="mt-4 text-4xl font-bold text-slate-900">{{ $applicationCount }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Dashboard Action</p>
                    <p class="mt-4 text-slate-700">Browse jobs and apply to opportunities that match your skills.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
