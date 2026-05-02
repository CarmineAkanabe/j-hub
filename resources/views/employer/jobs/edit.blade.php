@extends('layouts.auth')

@section('sidebar')
    @include('components.sidebar.employer-sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Edit Job</h1>
                <p class="mt-2 text-sm text-slate-600">Update your job details and status.</p>
            </div>
        </div>

        <form action="{{ route('employer.jobs.update', $job) }}" method="POST"
            class="space-y-6 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            @csrf
            @method('PUT')

            <div class="grid gap-6 lg:grid-cols-2">
                <x-ui.input name="title" label="Job Title" value="{{ old('title', $job->title) }}" required />
                <x-ui.input name="location" label="Location" value="{{ old('location', $job->location) }}" required />
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-slate-700">Description</label>
                <textarea id="description" name="description" rows="6"
                    class="mt-2 block w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-primary-600 focus:ring-2 focus:ring-primary-100">{{ old('description', $job->description) }}</textarea>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <x-ui.input name="expected_salary" label="Expected Salary" type="number"
                    value="{{ old('expected_salary', $job->expected_salary) }}" placeholder="Optional" />
                <div>
                    <label for="status" class="block text-sm font-medium text-slate-700">Status</label>
                    <select id="status" name="status"
                        class="mt-2 block w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-primary-600 focus:ring-2 focus:ring-primary-100">
                        <option value="open" {{ old('status', $job->status->value) === 'open' ? 'selected' : '' }}>Open
                        </option>
                        <option value="paused" {{ old('status', $job->status->value) === 'paused' ? 'selected' : '' }}>
                            Paused</option>
                        <option value="closed" {{ old('status', $job->status->value) === 'closed' ? 'selected' : '' }}>
                            Closed</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                <a href="{{ route('employer.jobs.index') }}"
                    class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-50">Cancel</a>
                <x-ui.button type="submit" variant="primary">Save Changes</x-ui.button>
            </div>
        </form>
    </div>
@endsection
