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
      Schema::create('jobs', function (Blueprint $table) {
            $table->id(); // Khóa chính tự tăng
            $table->string('title'); // Tiêu đề công việc
            $table->text('description'); // Mô tả chi tiết
            $table->string('company')->nullable(); // Tên công ty
            $table->string('location')->nullable(); // Địa điểm
            $table->unsignedInteger('salary')->nullable()->comment('Lưu dưới dạng số nguyên, ví dụ: 10,000,000'); // Mức lương
            $table->timestamps(); // Tự động tạo cột created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
