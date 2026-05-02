@extends('layouts.auth')

@section('sidebar')
    @include('components.sidebar.jobseeker-sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">My Comments</h1>
                <p class="mt-2 text-sm text-slate-600">Review the comments you have made and the jobs they belong to.</p>
            </div>
        </div>

        @if (session('success'))
            <div>
                <x-ui.alert type="success">{{ session('success') }}</x-ui.alert>
            </div>
        @endif

        @if (session('error'))
            <div>
                <x-ui.alert type="error">{{ session('error') }}</x-ui.alert>
            </div>
        @endif

        <div class="grid gap-6">
            @forelse($comments as $comment)
                <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">{{ $comment->job->title }}</h2>
                            <p class="mt-1 text-sm text-slate-500">
                                {{ $comment->job->employer->company_name ?? $comment->job->employer->name }}
                                &middot; {{ $comment->job->location }}
                            </p>
                        </div>
                        <p class="text-sm text-slate-500">{{ $comment->date->format('M d, Y') }}</p>
                    </div>

                    <div class="mt-5 rounded-3xl border border-slate-100 bg-slate-50 p-5">
                        <p class="text-slate-700">{{ $comment->content }}</p>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                        <x-ui.button href="{{ route('jobs.show', $comment->job) }}#comment-{{ $comment->id }}"
                            variant="secondary">View Job</x-ui.button>
                        <x-ui.button href="{{ route('jobseeker.comments.edit', $comment) }}" variant="primary">Edit</x-ui.button>
                        <form method="POST" action="{{ route('jobseeker.comments.destroy', $comment) }}">
                            @csrf
                            @method('DELETE')
                            <x-ui.button type="submit" variant="danger">Delete</x-ui.button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-8 text-center">
                    <p class="text-slate-600">You have not commented on any jobs yet.</p>
                </div>
            @endforelse
        </div>

        <div class="pt-6">
            {{ $comments->links() }}
        </div>
    </div>
@endsection
