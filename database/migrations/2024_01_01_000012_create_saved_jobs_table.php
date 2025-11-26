<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saved_jobs', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_id')->constrained('jobs')->onDelete('cascade');
            $table->timestamp('saved_at')->useCurrent();
            $table->timestamp('update_at')->useCurrent();
            $table->primary(['user_id', 'job_id']);
            $table->index('job_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_jobs');
    }
};

