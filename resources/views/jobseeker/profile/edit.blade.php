@extends('layouts.auth')

@section('sidebar')
    @include('components.sidebar.jobseeker-sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Profile</h1>
                    <p class="mt-2 text-sm text-slate-600">Manage your job seeker profile, resume, and contact details.</p>
                </div>
            </div>

            @if (session('success'))
                <div class="mt-6">
                    <x-ui.alert type="success">{{ session('success') }}</x-ui.alert>
                </div>
            @endif

            @if (session('error'))
                <div class="mt-6">
                    <x-ui.alert type="error">{{ session('error') }}</x-ui.alert>
                </div>
            @endif

            <form method="POST" action="{{ route('jobseeker.profile.update') }}" class="mt-8 space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid gap-6 lg:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Name</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                            class="mt-2 w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900"
                            required>
                        @error('name')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                            class="mt-2 w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900"
                            required>
                        @error('email')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Resume</label>
                    <textarea name="resume" rows="6"
                        class="mt-2 w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900">{{ old('resume', auth()->user()->resume) }}</textarea>
                    @error('resume')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">New Password</label>
                        <input type="password" name="password"
                            class="mt-2 w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900">
                        @error('password')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Confirm Password</label>
                        <input type="password" name="password_confirmation"
                            class="mt-2 w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900">
                    </div>
                </div>

                <div class="flex justify-end">
                    <x-ui.button type="submit" variant="primary">Save Changes</x-ui.button>
                </div>
            </form>
        </div>
    </div>
@endsection
