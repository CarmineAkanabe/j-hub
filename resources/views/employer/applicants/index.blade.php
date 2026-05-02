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

            <div class="mt-8 space-y-4">
                @forelse($applications as $application)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-slate-900">{{ $application->job->title }}</h2>
                                <p class="mt-1 text-sm text-slate-500">{{ $application->job->location }} ·
                                    {{ $application->job->employer->company_name ?? $application->job->employer->name }}</p>
                                <p class="mt-2 text-sm text-slate-600">Candidate: {{ $application->jobSeeker->name }} ·
                                    {{ $application->jobSeeker->email }}</p>
                            </div>

                            <div class="space-y-2 text-right">
                                <x-ui.badge
                                    variant="{{ $application->status->value === 'accepted' ? 'success' : ($application->status->value === 'refused' ? 'error' : 'warning') }}">{{ ucfirst($application->status->value) }}</x-ui.badge>
                                <x-ui.button href="{{ route('employer.applicants.show', $application) }}"
                                    variant="secondary">View details</x-ui.button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-10 text-center text-slate-600">
                        No applicant data is available yet. Applications will appear here once candidates apply.
                    </div>
                @endforelse
            </div>

            <div class="pt-6">
                {{ $applications->links() }}
            </div>
        </div>
    </div>
@endsection
