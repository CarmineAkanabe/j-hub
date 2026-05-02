@extends('layouts.auth')

@section('sidebar')
    @include('components.sidebar.employer-sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <h1 class="text-3xl font-bold text-slate-900">Applicants</h1>
            <p class="mt-2 text-sm text-slate-600">View applications from candidates who have expressed interest in your
                jobs.</p>

            <div class="mt-8 rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-10 text-center text-slate-600">
                No applicant data is available yet. Applications will appear here once candidates apply.
            </div>
        </div>
    </div>
@endsection
