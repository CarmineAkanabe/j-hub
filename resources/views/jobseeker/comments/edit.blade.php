@extends('layouts.auth')

@section('sidebar')
    @include('components.sidebar.jobseeker-sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Edit Comment</h1>
                <p class="mt-2 text-sm text-slate-600">Update your comment on {{ $comment->job->title }}.</p>
            </div>
            <x-ui.button href="{{ route('jobseeker.comments.index') }}" variant="secondary">Back to Comments</x-ui.button>
        </div>

        <article class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="rounded-3xl border border-slate-100 bg-slate-50 p-5">
                <h2 class="text-lg font-semibold text-slate-900">{{ $comment->job->title }}</h2>
                <p class="mt-1 text-sm text-slate-500">
                    {{ $comment->job->employer->company_name ?? $comment->job->employer->name }}
                    &middot; {{ $comment->job->location }}
                </p>
            </div>

            <form method="POST" action="{{ route('jobseeker.comments.update', $comment) }}" class="mt-6 space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label for="content" class="block text-sm font-medium text-slate-700">Comment</label>
                    <textarea id="content" name="content" rows="6"
                        class="mt-2 w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-slate-900 focus:ring-2 focus:ring-slate-200">{{ old('content', $comment->content) }}</textarea>
                    @error('content')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <x-ui.button href="{{ route('jobs.show', $comment->job) }}#comment-{{ $comment->id }}"
                        variant="secondary">View Job</x-ui.button>
                    <x-ui.button type="submit" variant="primary">Save Changes</x-ui.button>
                </div>
            </form>
        </article>
    </div>
@endsection
