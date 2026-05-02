@extends('layouts.auth')

@section('sidebar')
    @include('components.sidebar.jobseeker-sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <h1 class="text-3xl font-bold text-slate-900">Profile</h1>
            <p class="mt-2 text-sm text-slate-600">Manage your job seeker profile, resume, and contact details.</p>

            <div class="mt-8 rounded-3xl border border-slate-200 bg-slate-50 p-8 text-slate-700">
                <p class="font-semibold">Coming soon:</p>
                <p class="mt-2 text-sm">A profile editor for your resume, experience, and personal details.</p>
            </div>
        </div>
    </div>
@endsection
