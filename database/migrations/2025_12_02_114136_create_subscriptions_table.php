<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // create_subscriptions_table.php
public function up(): void
{
    Schema::create('subscriptions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('employer_profile_id')->constrained()->onDelete('cascade');
        $table->foreignId('plan_id')->constrained()->onDelete('cascade');
        
        // Thêm ->nullable() vào
        $table->timestamp('starts_at')->nullable();
        $table->timestamp('ends_at')->nullable();
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
