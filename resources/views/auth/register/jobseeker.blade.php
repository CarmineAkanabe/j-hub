@extends('layouts.auth')
@section('title', 'Register as Job Seeker')

@section('content')
    <div class="mx-auto max-w-md">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-slate-900">Create your account</h1>
            <p class="mt-2 text-slate-600">Join thousands of job seekers finding opportunities</p>
        </div>

        @if ($errors->any())
            <x-ui.alert type="error" title="Registration failed" class="mb-6">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-ui.alert>
        @endif

        <form method="POST" action="{{ route('register.jobseeker.store') }}" class="space-y-4">
            @csrf

            <x-ui.input name="name" type="text" label="Full Name" placeholder="John Doe" required />

            <x-ui.input name="email" type="email" label="Email" placeholder="you@example.com" required />

            <x-ui.input name="password" type="password" label="Password" placeholder="••••••••" required />

            <x-ui.input name="password_confirmation" type="password" label="Confirm Password" placeholder="••••••••"
                required />

            <x-ui.input name="resume" type="text" label="Resume or Bio (Optional)"
                placeholder="Tell employers about yourself" />

            <x-ui.button type="submit" variant="primary" class="w-full">
                Create Account
            </x-ui.button>
        </form>

        <div class="mt-6 border-t border-slate-200 pt-6 text-center text-sm text-slate-600">
            Already have an account?
            <a href="{{ route('login') }}" class="font-semibold text-slate-900 hover:underline">Log in</a>
            or
            <a href="{{ route('register.employer.show') }}" class="font-semibold text-slate-900 hover:underline">register as
                employer</a>
        </div>
    </div>
@endsection
