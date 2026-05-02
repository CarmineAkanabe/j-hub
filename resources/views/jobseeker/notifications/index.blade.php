@extends('layouts.auth')

@section('sidebar')
    @include('components.sidebar.jobseeker-sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <h1 class="text-3xl font-bold text-slate-900">Notifications</h1>
            <p class="mt-2 text-sm text-slate-600">Keep track of important updates about your job applications and activity.
            </p>

            @if ($notifications->count())
                <div class="mt-8 space-y-4">
                    @foreach ($notifications as $notification)
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                            <p class="text-slate-900">{{ $notification->message }}</p>
                            <p class="mt-2 text-sm text-slate-500">{{ $notification->date->format('M d, Y') }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="pt-6">
                    {{ $notifications->links() }}
                </div>
            @else
                <div
                    class="mt-8 rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-10 text-center text-slate-600">
                    No new notifications right now. We'll display updates here when available.
                </div>
            @endif
        </div>
    </div>
@endsection
