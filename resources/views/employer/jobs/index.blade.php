@extends('layouts.auth')

@section('sidebar')
    @include('components.sidebar.employer-sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        @if (session('success'))
            <x-ui.alert type="success">{{ session('success') }}</x-ui.alert>
        @endif

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Your Jobs</h1>
                <p class="mt-2 text-sm text-slate-600">Manage your live and archived job postings.</p>
            </div>
            <x-ui.button href="{{ route('employer.jobs.create') }}" variant="primary">New Job</x-ui.button>
        </div>

        <div class="grid gap-6">
            @forelse($jobs as $job)
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">{{ $job->title }}</h2>
                            <p class="mt-1 text-sm text-slate-500">{{ $job->location }} · {{ ucfirst($job->status->value) }}
                            </p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 text-sm text-slate-500">
                            <span>{{ $job->created_at->diffForHumans() }}</span>
                            <span>{{ $job->applications_count }} applications</span>
                        </div>
                    </div>

                    <p class="mt-4 text-sm text-slate-600 line-clamp-3">
                        {{ \Illuminate\Support\Str::limit($job->description, 160) }}</p>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <x-ui.button href="{{ route('employer.jobs.show', $job) }}" variant="secondary">View</x-ui.button>
                        <x-ui.button href="{{ route('employer.jobs.edit', $job) }}" variant="ghost"
                            class="border border-slate-200">Edit</x-ui.button>
                        <form action="{{ route('employer.jobs.destroy', $job) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <x-ui.button type="submit" variant="danger">Delete</x-ui.button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-8 text-center">
                    <p class="text-slate-600">You haven't posted any jobs yet.</p>
                    <div class="mt-4">
                        <x-ui.button href="{{ route('employer.jobs.create') }}">Post your first job</x-ui.button>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="pt-6">
            {{ $jobs->links() }}
        </div>
    </div>
@endsection
