<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up(): void
{
    Schema::create('plans', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // e.g., "Basic", "Premium"
        $table->string('slug')->unique();
        $table->decimal('price', 8, 2); // Giá mỗi tháng
        $table->json('features'); // Lưu các tính năng của gói, VD: ["post_jobs_limit" => 5, "can_search_cvs" => true]
        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
