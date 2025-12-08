<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SavedJobController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\CandidateSearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\VNPayController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

use App\Http\Controllers\Employer\ApplicationController as EmployerApplicationController;
use App\Http\Controllers\Employer\EmailTemplateController;
use Illuminate\Support\Facades\Artisan;

Route::get('/run-migrate', function () {
    Artisan::call('migrate', ['--force' => true]);
    return 'Migrated successfully!';
});

/*
|--------------------------------------------------------------------------
| VNPay Callback (Public)
|--------------------------------------------------------------------------
*/
Route::get('/employer/subscriptions/vnpay-return', [SubscriptionController::class, 'vnpayReturn'])
    ->name('employer.subscriptions.vnpay_return');

Route::get('/employer/subscriptions/vnpay-ipn', [SubscriptionController::class, 'vnpayIpn'])
    ->name('employer.subscriptions.vnpay_ipn');


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::middleware('web')->group(function () {

    // Home page
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Blog
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

    // Pricing
    Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');

    // Jobs (public view)
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{slug}', [JobController::class, 'show'])->name('jobs.show');

    // Public candidate profile
    Route::get('/candidate/{user}', [ProfileController::class, 'showPublic'])
        ->name('profile.public.show')
        ->where('user', '[0-9]+');

    // Static pages
    Route::view('/about', 'about')->name('about');
    Route::view('/privacy', 'privacy')->name('privacy');
    Route::view('/terms', 'terms')->name('terms');


    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);


    /*
    |--------------------------------------------------------------------------
    | Email Verification
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {
        Route::get('/email/verify', fn () => view('auth.verify-email'))
            ->name('verification.notice')
            ->middleware('throttle:6,1');

        Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
            $request->user()->sendEmailVerificationNotification();
            return back()->with('message', 'Verification link sent!');
        })->name('verification.send')->middleware('throttle:6,1');
    });

    Route::middleware(['signed', 'throttle:6,1'])->group(function () {
        Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
            $user = \App\Models\User::findOrFail($id);

            if (! hash_equals($hash, sha1($user->getEmailForVerification()))) {
                abort(403);
            }

            if (! $user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
                event(new \Illuminate\Auth\Events\Verified($user));
            }

            return redirect('/login')->with('success', 'Email verified. Please login.');
        })->name('verification.verify');
    });


    /*
    |--------------------------------------------------------------------------
    | Authenticated User Routes (Candidate + Employer + Admin)
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {

        // Notifications
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Comments
        Route::post('/jobs/{job}/comments', [CommentController::class, 'store'])->name('comments.store');
        Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
        Route::post('/comments/{comment}/like', [\App\Http\Controllers\CommentLikeController::class, 'toggle'])->name('comments.like');

        // Profile
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
        Route::put('/profile/candidate', [ProfileController::class, 'updateCandidate'])->name('profile.update.candidate');
        Route::put('/profile/employer', [ProfileController::class, 'updateEmployer'])->name('profile.update.employer');


        /*
        |--------------------------------------------------------------------------
        | Candidate-Specific Routes
        |--------------------------------------------------------------------------
        */
        Route::middleware('role:candidate')->group(function () {

            // Experience & Education
            Route::post('/profile/experience', [ProfileController::class, 'storeExperience'])->name('profile.experience.store');
            Route::put('/profile/experience/{experience}', [ProfileController::class, 'updateExperience'])->name('profile.experience.update');
            Route::delete('/profile/experience/{experience}', [ProfileController::class, 'destroyExperience'])->name('profile.experience.destroy');

            Route::post('/profile/education', [ProfileController::class, 'storeEducation'])->name('profile.education.store');
            Route::put('/profile/education/{education}', [ProfileController::class, 'updateEducation'])->name('profile.education.update');
            Route::delete('/profile/education/{education}', [ProfileController::class, 'destroyEducation'])->name('profile.education.destroy');

            // Job Applications
            Route::get('/applications', [JobApplicationController::class, 'index'])->name('applications.index');
            Route::get('/applications/{application}', [JobApplicationController::class, 'show'])->name('applications.show');
            Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('applications.store');
            Route::delete('/applications/{application}', [JobApplicationController::class, 'destroy'])->name('applications.destroy');

            // Saved Jobs
            Route::get('/saved-jobs', [SavedJobController::class, 'index'])->name('saved-jobs.index');
            Route::post('/saved-jobs/{job}', [SavedJobController::class, 'store'])->name('saved-jobs.store');
            Route::delete('/saved-jobs/{job}', [SavedJobController::class, 'destroy'])->name('saved-jobs.destroy');
        });


        /*
        |--------------------------------------------------------------------------
        | Employer-Specific Routes
        |--------------------------------------------------------------------------
        */
        Route::middleware(['role:employer'])->prefix('employer')->name('employer.')->group(function () {

            // Job Applicants
            Route::get('/applications', [EmployerApplicationController::class, 'index'])->name('applications.index');
            Route::patch('/applications/{id}/status', [EmployerApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
            Route::patch('/applications/{id}/notes', [EmployerApplicationController::class, 'updateNotes'])->name('applications.updateNotes');
            Route::delete('/applications/{id}', [EmployerApplicationController::class, 'destroy'])->name('applications.destroy');

            Route::get('/applications/job/{job}', [EmployerApplicationController::class, 'showApplicants'])
                ->name('applications.showApplicants');

            // Email templates
            Route::resource('templates', EmailTemplateController::class);

            // Subscription
            Route::post('/subscribe', [SubscriptionController::class, 'store'])->name('subscriptions.store');
        });


        /*
        |--------------------------------------------------------------------------
        | Employer / Admin: Job Management
        |--------------------------------------------------------------------------
        */
        Route::middleware('role:employer,admin')->group(function () {
            Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
            Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
            Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
            Route::put('/jobs/{job}', [JobController::class, 'update'])->name('jobs.update');
            Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
            Route::get('/jobs/{job}/applications', [JobController::class, 'showApplicants'])->name('jobs.applicants');

            // Blog (Employer Dashboard)
            Route::get('/dashboard/blog/create', [BlogController::class, 'create'])->name('blog.create');
            Route::post('/dashboard/blog', [BlogController::class, 'store'])->name('blog.store');
            Route::get('/dashboard/blog/{post}/edit', [BlogController::class, 'edit'])->name('blog.edit');
            Route::put('/dashboard/blog/{post}', [BlogController::class, 'update'])->name('blog.update');
            Route::delete('/dashboard/blog/{post}', [BlogController::class, 'destroy'])->name('blog.destroy');
        });


        /*
        |--------------------------------------------------------------------------
        | Employer Search Candidates (Gate)
        |--------------------------------------------------------------------------
        */
        Route::middleware(['role:employer'])->group(function () {
            Route::get('/candidates/search', [CandidateSearchController::class, 'index'])
                ->name('candidates.search')
                ->can('search-candidates');
        });


        /*
        |--------------------------------------------------------------------------
        | Admin Panel
        |--------------------------------------------------------------------------
        */
        Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

            // Dashboard
            Route::get('/', fn () => redirect()->route('admin.dashboard'));
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

            // Users
            Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
            Route::patch('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.update-role');
            Route::get('/users/roles', [AdminUserController::class, 'manageRoles'])->name('users.manage-roles');
            Route::post('/users/bulk-update-roles', [AdminUserController::class, 'bulkUpdateRoles'])->name('users.bulk-update-roles');
            Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

            // Jobs
            Route::get('/jobs', [AdminJobController::class, 'index'])->name('jobs.index');
            Route::patch('/jobs/{job}/status', [AdminJobController::class, 'updateStatus'])->name('jobs.update-status');
            Route::delete('/jobs/{job}', [AdminJobController::class, 'destroy'])->name('jobs.destroy');

            // Applications
            Route::get('/applications', [AdminApplicationController::class, 'index'])->name('applications.index');
            Route::patch('/applications/{application}/status', [AdminApplicationController::class, 'updateStatus'])->name('applications.update-status');
            Route::delete('/applications/{application}', [AdminApplicationController::class, 'destroy'])->name('applications.destroy');
        });

    }); // END Authenticated
}); // END Middleware Web

