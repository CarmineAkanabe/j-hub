@extends('layouts.public')

@section('content')
    <section class="space-y-8">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Browse Jobs</h1>
                <p class="mt-2 text-sm text-slate-600">Search the latest openings and filter by location.</p>
            </div>
            <div class="rounded-full bg-slate-100 px-4 py-2 text-sm text-slate-700">
                {{ $jobs->total() }} Open Jobs</div>
        </div>

        <div class="grid gap-8 lg:grid-cols-[280px_1fr]">
            <aside>
                <form method="GET" action="{{ route('jobs.index') }}" class="space-y-6">
                    @include('public.jobs.partials.search-bar')
                    @include('public.jobs.partials.filters')
                </form>
            </aside>

            <div class="space-y-6">
                @if ($jobs->count())
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-2">
                        @foreach ($jobs as $job)
                            <x-job.job-card :job="$job" />
                        @endforeach
                    </div>

                    <div class="pt-6">
                        {{ $jobs->links() }}
                    </div>
                @else
                    <div class="rounded-3xl border border-slate-200 bg-white p-10 text-center shadow-sm">
                        <h2 class="text-2xl font-semibold text-slate-900 mb-2">No jobs found</h2>
                        <p class="text-sm text-slate-600 mb-6">Try a different keyword or location to discover roles.</p>
                        <a href="{{ route('jobs.index') }}"
                            class="inline-flex rounded-full bg-primary-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-primary-700">Reset
                            Search</a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
