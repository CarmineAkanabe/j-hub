<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Job;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Job $job)
    {
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
                'date' => now()->toDateString(),
            ]);
        }

        return back()->with('success', 'Your comment has been posted.');
    }
}
