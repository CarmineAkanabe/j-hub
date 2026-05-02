@extends('layouts.auth')

@section('sidebar')
    @include('components.sidebar.employer-sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Applicant Details</h1>
                <p class="mt-2 text-sm text-slate-600">Review the candidate information and application details for this
                    posting.</p>
            </div>
            <x-ui.button href="{{ route('employer.applicants.index') }}" variant="secondary">Back to Applicants</x-ui.button>
        </div>

        @if (session('success'))
            <div class="mb-6">
                <x-ui.alert type="success">{{ session('success') }}</x-ui.alert>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6">
                <x-ui.alert type="error">{{ session('error') }}</x-ui.alert>
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-[1fr_320px]">
            <article class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="space-y-6">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">Candidate Information</h2>
                        <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm text-slate-500">Name</dt>
                                <dd class="mt-1 text-base font-semibold text-slate-900">{{ $application->jobSeeker->name }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm text-slate-500">Email</dt>
                                <dd class="mt-1 text-base font-semibold text-slate-900">{{ $application->jobSeeker->email }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm text-slate-500">Applied</dt>
                                <dd class="mt-1 text-base font-semibold text-slate-900">
                                    {{ $application->date->format('M d, Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-slate-500">Status</dt>
                                <dd class="mt-1">
                                    <x-ui.badge
                                        variant="{{ $application->status->value === 'accepted' ? 'success' : ($application->status->value === 'refused' ? 'error' : 'warning') }}">{{ ucfirst($application->status->value) }}</x-ui.badge>
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">Job Posting</h2>
                        <p class="mt-4 text-base font-semibold text-slate-900">{{ $application->job->title }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ $application->job->location }} ·
                            {{ ucfirst($application->job->status->value) }}</p>
                        <div class="mt-4 rounded-3xl border border-slate-200 bg-slate-50 p-6">
                            <p class="text-sm text-slate-500">Employer:</p>
                            <p class="mt-2 text-slate-900">
                                {{ $application->job->employer->company_name ?? $application->job->employer->name }}</p>
                        </div>
                    </div>

                    @if ($application->status->value === 'pending')
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                            <h2 class="text-lg font-semibold text-slate-900">Decision</h2>
                            <p class="mt-3 text-sm text-slate-600">Update the application status for this candidate.</p>
                            <div class="mt-5 flex flex-col gap-3 sm:flex-row">
                                <form method="POST"
                                    action="{{ route('employer.applicants.updateStatus', $application) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="accepted">
                                    <x-ui.button type="submit" variant="primary">Accept</x-ui.button>
                                </form>
                                <form method="POST"
                                    action="{{ route('employer.applicants.updateStatus', $application) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="refused">
                                    <x-ui.button type="submit" variant="danger">Refuse</x-ui.button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </article>

            <aside class="rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Application Notes</h2>
                <p class="mt-4 text-sm text-slate-600">If you want, add candidate review notes when you expand this feature
                    later.</p>
                <div class="mt-6 space-y-4">
                    <div class="rounded-3xl bg-white p-4">
                        <p class="text-sm text-slate-500">Role</p>
                        <p class="mt-1 text-slate-900">{{ $application->job->title }}</p>
                    </div>
                    <div class="rounded-3xl bg-white p-4">
                        <p class="text-sm text-slate-500">Location</p>
                        <p class="mt-1 text-slate-900">{{ $application->job->location }}</p>
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection
