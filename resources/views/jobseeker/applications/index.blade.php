@extends('layouts.auth')

@section('sidebar')
    @include('components.sidebar.jobseeker-sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">My Applications</h1>
                <p class="mt-2 text-sm text-slate-600">Review the roles you have applied to and check application status.</p>
            </div>
        </div>

        <div class="grid gap-6">
            @forelse($applications as $application)
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">{{ $application->job->title }}</h2>
                            <p class="mt-1 text-sm text-slate-500">{{ $application->job->location }} ·
                                {{ $application->job->employer->company_name ?? $application->job->employer->name }}</p>
                        </div>
                        <span
                            class="rounded-full bg-slate-100 px-3 py-2 text-sm text-slate-700">{{ ucfirst($application->status->value) }}</span>
                    </div>

                    <p class="mt-4 text-sm text-slate-600">Applied on {{ $application->date->format('M d, Y') }}</p>

                    <div class="mt-6">
                        <x-ui.button href="{{ route('jobseeker.applications.show', $application) }}"
                            variant="secondary">View Application</x-ui.button>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-8 text-center">
                    <p class="text-slate-600">You have not applied to any jobs yet.</p>
                </div>
            @endforelse
        </div>

        <div class="pt-6">
            {{ $applications->links() }}
        </div>
    </div>
@endsection
