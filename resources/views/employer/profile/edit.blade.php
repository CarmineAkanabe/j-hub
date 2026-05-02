@extends('layouts.auth')

@section('sidebar')
    @include('components.sidebar.employer-sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <h1 class="text-3xl font-bold text-slate-900">Company Profile</h1>
            <p class="mt-2 text-sm text-slate-600">Update your company information so applicants know who they're applying
                to.</p>

            <div class="mt-8 rounded-3xl border border-slate-200 bg-slate-50 p-8 text-slate-700">
                <p class="font-semibold">Coming soon:</p>
                <p class="mt-2 text-sm">A full employer profile editor with company details, branding, and contact
                    preferences.</p>
            </div>
        </div>
    </div>
@endsection
