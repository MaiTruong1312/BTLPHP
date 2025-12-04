<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            // Add new values and change the default value
            $table->enum('status', ['draft', 'published', 'closed', 'pending_approval', 'rejected'])
                  ->default('pending_approval')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            // Revert to the old definition
            $table->enum('status', ['draft', 'published', 'closed'])
                  ->default('published')->change();
        });
    }
};
