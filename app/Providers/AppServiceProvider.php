<?php

namespace App\Providers;
use App\Models\User;
use App\Models\Job;
use App\Models\JobApplication;
use App\Policies\JobApplicationPolicy;
use App\Policies\JobPolicy;
use App\Models\Post;
use App\Policies\PostPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Job::class, JobPolicy::class);
        Gate::policy(JobApplication::class, JobApplicationPolicy::class);
        Gate::policy(Post::class, PostPolicy::class);

        Gate::define('search-candidates', function (User $user) {
        // Kiểm tra người dùng có phải là nhà tuyển dụng không
        if (!$user->isEmployer() || !$user->employerProfile) {
            return false;
        }

        // Kiểm tra xem họ có gói dịch vụ còn hạn và gói đó có tính năng 'can_search_cvs' không
        $subscription = $user->employerProfile->subscriptions()
                            ->where('ends_at', '>', now())
                            ->latest('ends_at')
                            ->first();

        if (!$subscription) {
            return false;
        }

        $features = $subscription->plan->features;
        return $features['can_search_cvs'] ?? false;
    });
    }
}
