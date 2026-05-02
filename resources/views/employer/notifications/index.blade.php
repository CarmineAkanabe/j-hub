@extends('layouts.auth')

@section('sidebar')
    @include('components.sidebar.employer-sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <h1 class="text-3xl font-bold text-slate-900">Notifications</h1>
            <p class="mt-2 text-sm text-slate-600">Stay up to date with the latest candidate activity and platform alerts.
            </p>

            <div class="mt-8 rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-10 text-center text-slate-600">
                No notifications yet. Important updates will appear here when available.
            </div>
        </div>
    </div>
@endsection
