@extends('layouts.auth')

@section('sidebar')
    @include('components.sidebar.employer-sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">{{ $job->title }}</h1>
                <p class="mt-2 text-sm text-slate-600">{{ $job->location }} · {{ ucfirst($job->status->value) }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <x-ui.button href="{{ route('employer.jobs.edit', $job) }}" variant="secondary">Edit Job</x-ui.button>
                <form action="{{ route('employer.jobs.destroy', $job) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-full bg-rose-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-700">Remove
                        Job</button>
                </form>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1fr_280px]">
            <article class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="prose prose-slate max-w-none">
                    {!! nl2br(e($job->description)) !!}
                </div>
            </article>

            <aside class="rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
                <div class="space-y-4">
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Company</p>
                        <p class="mt-2 text-base text-slate-900">{{ $job->employer->company_name ?? $job->employer->name }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Applications</p>
                        <p class="mt-2 text-base text-slate-900">{{ $job->applications->count() }}</p>
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection
