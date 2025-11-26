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
            $table->foreignId('employer_profile_id')->nullable()->constrained('employer_profiles')->onDelete('set null');
            $table->foreignId('category_id')->constrained('job_categories')->onDelete('restrict');
            $table->foreignId('location_id')->constrained('job_locations')->onDelete('restrict');
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
            $table->enum('status', ['draft', 'published', 'closed'])->default('published');
            $table->integer('views_count')->default(0);
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('category_id');
            $table->index('location_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};

