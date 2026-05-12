<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;

class JobPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isEmployer() || $user->isAdmin();
    }

    public function view(User $user, Job $job): bool
    {
        return $job->employer_id === $user->id || $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isEmployer();
    }

    public function update(User $user, Job $job): bool
    {
        return $user->isEmployer() && $job->employer_id === $user->id;
    }

    public function delete(User $user, Job $job): bool
    {
        return $user->isEmployer() && $job->employer_id === $user->id;
    }

    public function restore(User $user, Job $job): bool
    {
        return false;
    }

    public function forceDelete(User $user, Job $job): bool
    {
        return false;
    }
}
