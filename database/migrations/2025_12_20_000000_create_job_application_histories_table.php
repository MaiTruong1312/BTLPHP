<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_application_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_application_id')->constrained('job_applications')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Người thực hiện thay đổi
            $table->string('from_status')->nullable();
            $table->string('to_status');
            $table->text('note')->nullable(); // Lý do hoặc ghi chú tự động
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_application_histories');
    }
};
