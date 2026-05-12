<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Comment::class);

        $comments = auth()->user()
            ->comments()
            ->with('job.employer')
            ->latest()
            ->paginate(10);

        return view('jobseeker.comments.index', compact('comments'));
    }

    public function store(Request $request, Job $job)
    {
        Gate::authorize('create', [Comment::class, $job]);

        $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ]);

        $user = auth()->user();

        $comment = $job->comments()->create([
            'user_id' => $user->id,
            'content' => $request->input('content'),
            'date' => now()->toDateString(),
        ]);

        if ($job->employer) {
            $job->employer->notifications()->create([
                'message' => "New comment from {$user->name} on {$job->title}.",
                'action_url' => route('jobs.show', $job) . '#comment-' . $comment->id,
                'date' => now()->toDateString(),
            ]);
        }

        return back()->with('success', 'Your comment has been posted.');
    }

    public function edit(Comment $comment)
    {
        $comment->load('job.employer');

        Gate::authorize('update', $comment);

        return view('jobseeker.comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ]);

        $comment->load('job.employer');

        Gate::authorize('update', $comment);

        $comment->update([
            'content' => $request->input('content'),
            'date' => now()->toDateString(),
        ]);

        if ($comment->job->employer) {
            $comment->job->employer->notifications()->create([
                'message' => auth()->user()->name . " updated a comment on {$comment->job->title}.",
                'action_url' => route('jobs.show', $comment->job) . '#comment-' . $comment->id,
                'date' => now()->toDateString(),
            ]);
        }

        return redirect()->route('jobseeker.comments.index')->with('success', 'Your comment has been updated.');
    }

    public function destroy(Comment $comment)
    {
        $comment->load('job.employer');

        Gate::authorize('delete', $comment);

        $job = $comment->job;

        if ($job->employer) {
            $job->employer->notifications()->create([
                'message' => auth()->user()->name . " deleted a comment on {$job->title}.",
                'action_url' => route('jobs.show', $job),
                'date' => now()->toDateString(),
            ]);
        }

        $comment->delete();

        return redirect()->route('jobseeker.comments.index')->with('success', 'Your comment has been deleted.');
    }
}
