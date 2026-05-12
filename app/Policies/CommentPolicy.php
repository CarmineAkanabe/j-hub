<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Job;
use App\Models\User;

class CommentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isJobSeeker() || $user->isAdmin();
    }

    public function view(User $user, Comment $comment): bool
    {
        return $user->isAdmin()
            || $comment->user_id === $user->id
            || $comment->job?->employer_id === $user->id;
    }

    public function create(User $user, ?Job $job = null): bool
    {
        return $user->isJobSeeker();
    }

    public function update(User $user, Comment $comment): bool
    {
        return $user->isJobSeeker() && $comment->user_id === $user->id;
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $user->isJobSeeker() && $comment->user_id === $user->id;
    }

    public function restore(User $user, Comment $comment): bool
    {
        return false;
    }

    public function forceDelete(User $user, Comment $comment): bool
    {
        return false;
    }
}
