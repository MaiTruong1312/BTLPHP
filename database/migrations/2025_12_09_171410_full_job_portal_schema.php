<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Basic support tables (cache, sessions, tokens, queues...)
        |--------------------------------------------------------------------------
        */

        // Schema::create('cache', function (Blueprint $table) {
        //     $table->string('key', 255)->primary();
        //     $table->mediumText('value');
        //     $table->integer('expiration');
        // });

        // Schema::create('cache_locks', function (Blueprint $table) {
        //     $table->string('key', 255)->primary();
        //     $table->string('owner', 255);
        //     $table->integer('expiration');
        // });

        // Schema::create('failed_jobs', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->string('uuid')->unique();
        //     $table->text('connection');
        //     $table->text('queue');
        //     $table->longText('payload');
        //     $table->longText('exception');
        //     $table->timestamp('failed_at')->useCurrent();
        // });

        // Schema::create('job_batches', function (Blueprint $table) {
        //     $table->string('id')->primary();
        //     $table->string('name');
        //     $table->integer('total_jobs');
        //     $table->integer('pending_jobs');
        //     $table->integer('failed_jobs');
        //     $table->longText('failed_job_ids');
        //     $table->mediumText('options')->nullable();
        //     $table->integer('cancelled_at')->nullable();
        //     $table->integer('created_at');
        //     $table->integer('finished_at')->nullable();
        // });

        // Schema::create('migrations', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('migration');
        //     $table->integer('batch');
        // });

        // Schema::create('password_reset_tokens', function (Blueprint $table) {
        //     $table->string('email')->primary();
        //     $table->string('token');
        //     $table->timestamp('created_at')->nullable();
        // });

        // Schema::create('personal_access_tokens', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->stringMorphs('tokenable');
        //     $table->string('name');
        //     $table->string('token', 64)->unique();
        //     $table->text('abilities')->nullable();
        //     $table->timestamp('last_used_at')->nullable();
        //     $table->timestamp('expires_at')->nullable();
        //     $table->timestamps();
        // });

        // Schema::create('sessions', function (Blueprint $table) {
        //     $table->string('id')->primary();
        //     $table->unsignedBigInteger('user_id')->nullable();
        //     $table->string('ip_address', 45)->nullable();
        //     $table->text('user_agent')->nullable();
        //     $table->longText('payload');
        //     $table->integer('last_activity');

        //     $table->index('user_id', 'sessions_user_id_index');
        //     $table->index('last_activity', 'sessions_last_activity_index');
        // });

        Schema::create('queue_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue');
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');

            $table->index('queue', 'queue_jobs_queue_index');
        });

        /*
        |--------------------------------------------------------------------------
        | Core domain tables (users, categories, locations, skills, plans...)
        |--------------------------------------------------------------------------
        */

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['candidate', 'employer', 'admin'])->default('candidate');
            $table->string('avatar')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index('role', 'users_role_index');
        });

        Schema::create('job_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('job_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('city');
            $table->string('country')->default('Vietnam');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 8, 2);
            $table->json('features');
            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | Profiles (employer & candidate)
        |--------------------------------------------------------------------------
        */

        Schema::create('employer_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('company_name');
            $table->string('company_slug')->unique();
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('address')->nullable();
            $table->enum('company_size', ['1-10', '11-50', '51-200', '201-500', '501-1000', '1000+'])->nullable();
            $table->text('about')->nullable();
            $table->timestamps();
        });

        Schema::create('candidate_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('phone', 20)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('address')->nullable();
            $table->text('summary')->nullable();
            $table->string('cv_path')->nullable();
            $table->boolean('is_searchable')->default(false);
            $table->integer('years_of_experience')->nullable();
            $table->integer('expected_salary_min')->nullable();
            $table->integer('expected_salary_max')->nullable();
            $table->timestamps();
        });

        Schema::create('candidate_experiences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('candidate_profile_id')
                ->constrained('candidate_profiles')
                ->cascadeOnDelete();
            $table->string('company_name');
            $table->string('position');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('candidate_profile_id', 'candidate_experiences_candidate_profile_id_index');
        });

        Schema::create('candidate_education', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('candidate_profile_id')
                ->constrained('candidate_profiles')
                ->cascadeOnDelete();
            $table->string('school_name');
            $table->string('degree')->nullable();
            $table->string('field_of_study')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('candidate_profile_id', 'candidate_educations_candidate_profile_id_index');
        });

        Schema::create('candidate_skill', function (Blueprint $table) {
            $table->foreignId('candidate_profile_id')
                ->constrained('candidate_profiles')
                ->cascadeOnDelete();
            $table->foreignId('skill_id')
                ->constrained('skills')
                ->cascadeOnDelete();

            $table->primary(['candidate_profile_id', 'skill_id']);
            $table->index('skill_id', 'candidate_skill_skill_id_index');
        });

        /*
        |--------------------------------------------------------------------------
        | Job postings & related (jobs, applications, saved, skills)
        |--------------------------------------------------------------------------
        */

        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('employer_profile_id')
                ->nullable()
                ->constrained('employer_profiles')
                ->nullOnDelete();
            $table->foreignId('category_id')
                ->constrained('job_categories');
            $table->foreignId('location_id')
                ->constrained('job_locations');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('short_description')->nullable();
            $table->longText('description');
            $table->longText('requirements')->nullable();
            $table->integer('salary_min')->nullable();
            $table->integer('salary_max')->nullable();
            $table->string('currency', 10)->default('VND');
            $table->enum('salary_type', ['month', 'year', 'hour', 'negotiable'])->default('month');
            $table->enum('job_type', ['full_time', 'part_time', 'internship', 'freelance', 'remote'])->default('full_time');
            $table->enum('experience_level', ['junior', 'mid', 'senior', 'lead'])->nullable();
            $table->boolean('is_remote')->default(false);
            $table->integer('vacancies')->default(1);
            $table->date('deadline')->nullable();
            $table->enum('status', ['draft', 'published', 'closed', 'pending_approval', 'rejected'])
                ->default('pending_approval');
            $table->integer('views_count')->default(0);
            $table->timestamps();

            $table->index('user_id', 'jobs_user_id_index');
            $table->index('category_id', 'jobs_category_id_index');
            $table->index('location_id', 'jobs_location_id_index');
            $table->index('employer_profile_id', 'jobs_employer_profile_id_foreign');
            $table->index('status', 'jobs_status_index');
        });

        Schema::create('job_skill', function (Blueprint $table) {
            $table->foreignId('job_id')
                ->constrained('jobs')
                ->cascadeOnDelete();
            $table->foreignId('skill_id')
                ->constrained('skills')
                ->cascadeOnDelete();

            $table->primary(['job_id', 'skill_id']);
            $table->index('skill_id', 'job_skill_skill_id_index');
        });

        Schema::create('job_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('job_id')
                ->constrained('jobs')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('candidate_profile_id')
                ->nullable()
                ->constrained('candidate_profiles')
                ->nullOnDelete();
            $table->longText('cover_letter')->nullable();
            $table->string('cv_path')->nullable();
            $table->enum('status', ['applied', 'reviewing', 'interview', 'offered', 'rejected', 'withdrawn'])
                ->default('applied');
            $table->text('rejection_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('applied_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('job_id', 'job_applications_job_id_index');
            $table->index('user_id', 'job_applications_user_id_index');
            $table->index('candidate_profile_id', 'job_applications_candidate_profile_id_foreign');
            $table->index('status', 'job_applications_status_index');
        });

        Schema::create('saved_jobs', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('job_id')
                ->constrained('jobs')
                ->cascadeOnDelete();
            $table->timestamp('saved_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->primary(['user_id', 'job_id']);
            $table->index('job_id', 'saved_jobs_job_id_index');
        });

        /*
        |--------------------------------------------------------------------------
        | Blog posts & email templates
        |--------------------------------------------------------------------------
        */

        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->string('image')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index('user_id', 'posts_user_id_foreign');
        });

        Schema::create('email_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('name');
            $table->string('subject');
            $table->text('body');
            $table->string('type');
            $table->timestamps();

            $table->index('user_id', 'email_templates_user_id_foreign');
            $table->index('type', 'email_templates_type_index');
        });

        /*
        |--------------------------------------------------------------------------
        | Notifications & subscriptions
        |--------------------------------------------------------------------------
        */

        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['notifiable_type', 'notifiable_id'], 'notifications_notifiable_type_notifiable_id_index');
        });

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('employer_profile_id')
                ->constrained('employer_profiles')
                ->cascadeOnDelete();
            $table->foreignId('plan_id')
                ->constrained('plans')
                ->cascadeOnDelete();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();

            $table->index('employer_profile_id', 'subscriptions_employer_profile_id_foreign');
            $table->index('plan_id', 'subscriptions_plan_id_foreign');
        });

        /*
        |--------------------------------------------------------------------------
        | Comments & likes
        |--------------------------------------------------------------------------
        */

        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('job_id')
                ->constrained('jobs')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('content');
            $table->timestamps();

            $table->index('job_id', 'comments_job_id_foreign');
            $table->index('user_id', 'comments_user_id_foreign');
            $table->index('parent_id', 'comments_parent_id_foreign');

            $table->foreign('parent_id')
                ->references('id')
                ->on('comments')
                ->cascadeOnDelete();
        });

        Schema::create('comment_likes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('comment_id')
                ->constrained('comments')
                ->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'comment_id'], 'comment_likes_user_id_comment_id_unique');
            $table->index('comment_id', 'comment_likes_comment_id_foreign');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop tables in reverse dependency order to avoid FK conflicts
        Schema::dropIfExists('comment_likes');
        Schema::dropIfExists('comments');

        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('email_templates');
        Schema::dropIfExists('posts');

        Schema::dropIfExists('saved_jobs');
        Schema::dropIfExists('job_applications');
        Schema::dropIfExists('job_skill');
        Schema::dropIfExists('jobs');

        Schema::dropIfExists('candidate_skill');
        Schema::dropIfExists('candidate_education');
        Schema::dropIfExists('candidate_experiences');
        Schema::dropIfExists('candidate_profiles');
        Schema::dropIfExists('employer_profiles');

        Schema::dropIfExists('plans');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('job_locations');
        Schema::dropIfExists('job_categories');
        Schema::dropIfExists('users');

        Schema::dropIfExists('queue_jobs');
        // Schema::dropIfExists('sessions');
        // Schema::dropIfExists('personal_access_tokens');
        // Schema::dropIfExists('password_reset_tokens');
        // Schema::dropIfExists('migrations');
        // Schema::dropIfExists('job_batches');
        // Schema::dropIfExists('failed_jobs');
        // Schema::dropIfExists('cache_locks');
        // Schema::dropIfExists('cache');
    }
};
