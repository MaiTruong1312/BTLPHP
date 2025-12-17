<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interview_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_id')->constrained('interviews')->onDelete('cascade');
            $table->foreignId('evaluator_id')->constrained('users')->onDelete('cascade');
            $table->unsignedTinyInteger('rating'); // 1-5 stars
            $table->text('strengths')->nullable();
            $table->text('weaknesses')->nullable();
            $table->text('overall_comment');
            $table->timestamps();

            $table->unique('interview_id'); // Mỗi cuộc phỏng vấn chỉ có một đánh giá
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interview_evaluations');
    }
};
