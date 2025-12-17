<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_application_id')->constrained('job_applications')->onDelete('cascade');
            $table->foreignId('interviewer_id')->constrained('users')->onDelete('cascade'); // Người tạo lịch (Employer)
            
            $table->dateTime('scheduled_at'); // Thời gian bắt đầu phỏng vấn
            $table->integer('duration_minutes')->default(60); // Thời lượng (phút)
            
            $table->enum('type', ['online', 'offline'])->default('online');
            $table->string('location')->nullable(); // Link Google Meet/Zoom hoặc địa chỉ văn phòng
            $table->text('notes')->nullable(); // Ghi chú cho ứng viên
            
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])->default('scheduled');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};