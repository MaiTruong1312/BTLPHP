<?php

namespace App\Providers;

use App\Models\Job;
use App\Models\JobApplication;
use App\Policies\JobApplicationPolicy;
use App\Policies\JobPolicy;
use App\Models\Post;
use App\Policies\PostPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Job::class => JobPolicy::class,
        JobApplication::class => JobApplicationPolicy::class,
        Post::class => PostPolicy::class,
    ];

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
    }
}
