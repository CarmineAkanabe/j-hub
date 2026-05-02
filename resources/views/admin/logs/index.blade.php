@extends('layouts.auth')

@section('sidebar')
    @include('components.sidebar.admin-sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Logs</h1>
                    <p class="mt-2 text-sm text-slate-600">Quick activity history for recent user and platform events.</p>
                </div>
            </div>

            <div class="mt-8 space-y-4">
                @forelse($activity as $item)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                        <p class="text-slate-900">{{ $item['message'] }}</p>
                        <p class="mt-2 text-sm text-slate-500">{{ $item['date']->format('M d, Y H:i') }}</p>
                    </div>
                @empty
                    <div
                        class="rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-10 text-center text-slate-600">
                        No log activity is available yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
