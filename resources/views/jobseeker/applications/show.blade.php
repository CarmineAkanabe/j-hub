@extends('layouts.auth')

@section('sidebar')
    @include('components.sidebar.jobseeker-sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">{{ $application->job->title }}</h1>
                <p class="mt-2 text-sm text-slate-600">Application status:
                    <strong>{{ ucfirst($application->status->value) }}</strong></p>
            </div>
            <x-ui.button href="{{ route('jobseeker.applications.index') }}" variant="secondary">Back to
                Applications</x-ui.button>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1fr_300px]">
            <article class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="space-y-4">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">Job Details</h2>
                        <p class="mt-2 text-sm text-slate-600">{{ $application->job->description }}</p>
                    </div>
                    <div class="rounded-3xl border border-slate-100 bg-slate-50 p-6">
                        <p class="text-sm text-slate-500">Applied on {{ $application->date->format('M d, Y') }}</p>
                        <p class="mt-3 text-sm text-slate-600">Employer:
                            {{ $application->job->employer->company_name ?? $application->job->employer->name }}</p>
                    </div>
                </div>
            </article>

            <aside class="rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Application Summary</h2>
                <p class="mt-4 text-sm text-slate-600">Status: <strong>{{ ucfirst($application->status->value) }}</strong>
                </p>
                <p class="mt-2 text-sm text-slate-600">Job location: {{ $application->job->location }}</p>
                <p class="mt-2 text-sm text-slate-600">Salary:
                    {{ $application->job->expected_salary ? '$' . number_format($application->job->expected_salary) : 'Not listed' }}
                </p>
            </aside>
        </div>
    </div>
@endsection
