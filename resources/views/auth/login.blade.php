@extends('layouts.auth')
@section('title', 'Login')

@section('content')
    <div class="mx-auto max-w-md">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-slate-900">Welcome back</h1>
            <p class="mt-2 text-slate-600">Log in to your J-Hub account</p>
        </div>

        @if ($errors->any())
            <x-ui.alert type="error" title="Login failed" class="mb-6">
                {{ $errors->first() }}
            </x-ui.alert>
        @endif

        <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
            @csrf

            <x-ui.input name="email" type="email" label="Email" placeholder="you@example.com" required />

            <x-ui.input name="password" type="password" label="Password" placeholder="••••••••" required />

            <x-ui.button type="submit" variant="primary" class="w-full">
                Log in
            </x-ui.button>
        </form>

        <div class="mt-6 border-t border-slate-200 pt-6 text-center text-sm text-slate-600">
            Don't have an account?
            <a href="{{ route('register.jobseeker.show') }}" class="font-semibold text-slate-900 hover:underline">Sign up as
                job seeker</a>
            or
            <a href="{{ route('register.employer.show') }}" class="font-semibold text-slate-900 hover:underline">as
                employer</a>
        </div>
    </div>
@endsection
