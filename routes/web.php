<?php

use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SavedJobController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    // Home
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
    // Authentication
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Jobs
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');

    // Public Candidate Profile
    Route::get('/candidate/{user}', [ProfileController::class, 'showPublic'])->name('profile.public.show')->where('user', '[0-9]+');

    // Authenticated routes
    Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile/candidate', [ProfileController::class, 'updateCandidate'])->name('profile.update.candidate');
    Route::put('/profile/employer', [ProfileController::class, 'updateEmployer'])->name('profile.update.employer');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');

    // Candidate Experience & Education Management
    Route::middleware('role:candidate')->group(function() {
        Route::post('/profile/experience', [ProfileController::class, 'storeExperience'])->name('profile.experience.store');
        Route::put('/profile/experience/{experience}', [ProfileController::class, 'updateExperience'])->name('profile.experience.update');
        Route::delete('/profile/experience/{experience}', [ProfileController::class, 'destroyExperience'])->name('profile.experience.destroy');

        Route::post('/profile/education', [ProfileController::class, 'storeEducation'])->name('profile.education.store');
        Route::put('/profile/education/{education}', [ProfileController::class, 'updateEducation'])->name('profile.education.update');
        Route::delete('/profile/education/{education}', [ProfileController::class, 'destroyEducation'])->name('profile.education.destroy');
    });

    // Job Management (Employer)
    Route::middleware('role:employer,admin')->group(function () {
        Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit')->where('job', '[0-9]+');
        Route::put('/jobs/{job}', [JobController::class, 'update'])->name('jobs.update')->where('job', '[0-9]+');
        Route::get('/jobs/{job}/applications', [JobController::class, 'showApplicants'])->name('jobs.applicants')->where('job', '[0-9]+');
        Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy')->where('job', '[0-9]+');

        // Blog Management
        Route::get('/dashboard/blog/create', [BlogController::class, 'create'])->name('blog.create');
        Route::post('/dashboard/blog', [BlogController::class, 'store'])->name('blog.store');
        Route::get('/dashboard/blog/{post}/edit', [BlogController::class, 'edit'])->name('blog.edit');
        Route::put('/dashboard/blog/{post}', [BlogController::class, 'update'])->name('blog.update');
        Route::delete('/dashboard/blog/{post}', [BlogController::class, 'destroy'])->name('blog.destroy');

        // Route for employer to update application status
        Route::patch('/applications/{application}/status', [\App\Http\Controllers\Employer\ApplicationController::class, 'updateStatus'])->name('employer.applications.update-status')->where('application', '[0-9]+');
    });

    // Job Applications (Candidate)
    Route::middleware('role:candidate')->group(function () {
        Route::get('/applications', [JobApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{application}', [JobApplicationController::class, 'show'])->name('applications.show')->where('application', '[0-9]+');
        Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('applications.store')->where('job', '[0-9]+');
        Route::delete('/applications/{application}', [JobApplicationController::class, 'destroy'])->name('applications.destroy')->where('application', '[0-9]+');
    });

    // Saved Jobs (Candidate)
    Route::middleware('role:candidate')->group(function () {
        Route::get('/saved-jobs', [SavedJobController::class, 'index'])->name('saved-jobs.index');
        Route::post('/saved-jobs/{job}', [SavedJobController::class, 'store'])->name('saved-jobs.store')->where('job', '[0-9]+');
        Route::delete('/saved-jobs/{job}', [SavedJobController::class, 'destroy'])->name('saved-jobs.destroy')->where('job', '[0-9]+');
    });

    // Admin area
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Users
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.update-role')->where('user', '[0-9]+');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy')->where('user', '[0-9]+');

        // Jobs
        Route::get('/jobs', [AdminJobController::class, 'index'])->name('jobs.index');
        Route::patch('/jobs/{job}/status', [AdminJobController::class, 'updateStatus'])->name('jobs.update-status')->where('job', '[0-9]+');
        Route::delete('/jobs/{job}', [AdminJobController::class, 'destroy'])->name('jobs.destroy')->where('job', '[0-9]+');

        // Applications
        Route::get('/applications', [AdminApplicationController::class, 'index'])->name('applications.index');
        Route::patch('/applications/{application}/status', [AdminApplicationController::class, 'updateStatus'])->name('applications.update-status')->where('application', '[0-9]+');
        Route::delete('/applications/{application}', [AdminApplicationController::class, 'destroy'])->name('applications.destroy')->where('application', '[0-9]+');
    });
    });

    Route::get('/jobs/{slug}', [JobController::class, 'show'])->name('jobs.show');
});
