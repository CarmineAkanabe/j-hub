<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\Job;
use App\Models\User;

class ApplicationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isJobSeeker() || $user->isEmployer() || $user->isAdmin();
    }

    public function view(User $user, Application $application): bool
    {
        return $user->isAdmin()
            || $application->job_seeker_id === $user->id
            || $application->job?->employer_id === $user->id;
    }

    public function create(User $user, ?Job $job = null): bool
    {
        return $user->isJobSeeker();
    }

    public function update(User $user, Application $application): bool
    {
        return $user->isEmployer() && $application->job?->employer_id === $user->id;
    }

    public function delete(User $user, Application $application): bool
    {
        return false;
    }

    public function restore(User $user, Application $application): bool
    {
        return false;
    }

    public function forceDelete(User $user, Application $application): bool
    {
        return false;
    }
}
