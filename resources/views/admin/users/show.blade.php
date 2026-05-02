@extends('layouts.auth')

@section('sidebar')
    @include('components.sidebar.admin-sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">{{ $user->name }}</h1>
                    <p class="mt-2 text-sm text-slate-600">User details and account actions.</p>
                </div>
                @if ($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                        @csrf
                        @method('DELETE')
                        <x-ui.button type="submit" variant="danger">Delete Account</x-ui.button>
                    </form>
                @endif
            </div>

            <div class="mt-8 grid gap-6 sm:grid-cols-2">
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Name</p>
                    <p class="mt-2 text-lg font-semibold text-slate-900">{{ $user->name }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Email</p>
                    <p class="mt-2 text-lg font-semibold text-slate-900">{{ $user->email }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Role</p>
                    <p class="mt-2 text-lg font-semibold text-slate-900">{{ ucfirst($user->role->value) }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Joined</p>
                    <p class="mt-2 text-lg font-semibold text-slate-900">{{ $user->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
