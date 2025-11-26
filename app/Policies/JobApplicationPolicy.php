<?php

namespace App\Policies;

use App\Models\JobApplication;
use App\Models\User;

class JobApplicationPolicy
{
    public function view(User $user, JobApplication $application): bool
    {
        return $user->id === $application->user_id 
            || ($user->isEmployer() && $user->id === $application->job->user_id)
            || $user->isAdmin();
    }

    public function update(User $user, JobApplication $application): bool
    {
        return ($user->isEmployer() && $user->id === $application->job->user_id) || $user->isAdmin();
    }

    public function delete(User $user, JobApplication $application): bool
    {
        return $user->id === $application->user_id || $user->isAdmin();
    }
}

