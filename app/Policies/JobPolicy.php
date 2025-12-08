<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;

class JobPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Job $job): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isEmployer() && $user->employerProfile) {
            $employerProfile = $user->employerProfile;

            // Get all active subscriptions
            $activeSubscriptions = $employerProfile->subscriptions()
                ->where(function ($query) {
                    $query->where('ends_at', '>', now())
                        ->orWhereNull('ends_at');
                })
                ->with('plan') // Eager load the plan
                ->get();

            if ($activeSubscriptions->isEmpty()) {
                return false; // No active subscriptions
            }

            // Check if any of the active plans has unlimited posting
            foreach ($activeSubscriptions as $subscription) {
                if ($subscription->plan && isset($subscription->plan->features['post_jobs_limit']) && $subscription->plan->features['post_jobs_limit'] === -1) {
                    return true; // Found an unlimited plan
                }
            }

            // If no unlimited plan, find the maximum limit among all active plans
            $maxLimit = 0;
            foreach ($activeSubscriptions as $subscription) {
                if ($subscription->plan && isset($subscription->plan->features['post_jobs_limit'])) {
                    $limit = $subscription->plan->features['post_jobs_limit'];
                    if ($limit > $maxLimit) {
                        $maxLimit = $limit;
                    }
                }
            }
            
            if ($maxLimit === 0) {
                // This could happen if the basic plan has 0 post limit and it's the only one.
                return false;
            }

            $jobCount = $user->jobs()->count();

            return $jobCount < $maxLimit;
        }

        return false;
    }

    public function update(User $user, Job $job): bool
    {
        return $user->id === $job->user_id || $user->isAdmin();
    }

    public function delete(User $user, Job $job): bool
    {
        return $user->id === $job->user_id || $user->isAdmin();
    }
}

