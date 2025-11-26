<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('jobs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('candidate_profile_id')->nullable()->constrained('candidate_profiles')->onDelete('set null');
            $table->longText('cover_letter')->nullable();
            $table->string('cv_path')->nullable();
            $table->enum('status', ['applied', 'reviewing', 'interview', 'offered', 'rejected', 'withdrawn'])->default('applied');
            $table->timestamp('applied_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            
            $table->index('job_id');
            $table->index('user_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};

