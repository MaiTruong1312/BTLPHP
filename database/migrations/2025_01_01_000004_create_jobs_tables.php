<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('employer_profile_id')->nullable()->constrained('employer_profiles')->nullOnDelete();
            $table->foreignId('category_id')->constrained('job_categories');
            $table->foreignId('location_id')->constrained('job_locations');
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
            $table->boolean('is_remote')->default(0);
            $table->integer('vacancies')->default(1);
            $table->date('deadline')->nullable();
            $table->enum('status', ['draft', 'published', 'closed', 'pending_approval', 'rejected'])->default('pending_approval');
            $table->integer('views_count')->default(0);
            $table->timestamps();
        });

        // Pivot table: Job - Skill
        Schema::create('job_skill', function (Blueprint $table) {
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->primary(['job_id', 'skill_id']);
        });

        // Saved Jobs (User lưu việc làm)
        Schema::create('saved_jobs', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->timestamp('saved_at')->nullable();
            $table->timestamps(); // creates created_at & updated_at
            $table->primary(['user_id', 'job_id']);
        });

        // Job Applications
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('candidate_profile_id')->nullable()->constrained('candidate_profiles')->nullOnDelete();
            $table->longText('cover_letter')->nullable();
            $table->string('cv_path')->nullable();
            $table->enum('status', ['applied', 'reviewing', 'interview', 'offered', 'rejected', 'withdrawn'])->default('applied');
            $table->text('rejection_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('applied_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
        Schema::dropIfExists('saved_jobs');
        Schema::dropIfExists('job_skill');
        Schema::dropIfExists('jobs');
    }
};