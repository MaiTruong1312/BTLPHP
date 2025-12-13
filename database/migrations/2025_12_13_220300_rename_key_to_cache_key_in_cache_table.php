<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cache', function (Blueprint $table) {
            $table->renameColumn('key', 'cache_key');
        });
    }

    public function down(): void
    {
        Schema::table('cache', function (Blueprint $table) {
            $table->renameColumn('cache_key', 'key');
        });
    }
};
