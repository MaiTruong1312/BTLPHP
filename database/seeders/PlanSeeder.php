<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        // Tắt khóa ngoại để truncate không lỗi
        Schema::disableForeignKeyConstraints();
        Plan::truncate();
        Schema::enableForeignKeyConstraints();

        Plan::create([
            'name' => 'Basic',
            'slug' => 'basic',
            'price' => 0,
            'features' => [
                'post_jobs_limit' => 1,
                'can_search_cvs' => false,
                'featured_jobs' => 0,
            ],
        ]);

        Plan::create([
            'name' => 'Standard',
            'slug' => 'standard',
            'price' => 499000,
            'features' => [
                'post_jobs_limit' => 5,
                'can_search_cvs' => false,
                'featured_jobs' => 2,
            ],
        ]);

        Plan::create([
            'name' => 'Premium',
            'slug' => 'premium',
            'price' => 999000,
            'features' => [
                'post_jobs_limit' => -1,
                'can_search_cvs' => true,
                'featured_jobs' => 5,
            ],
        ]);
    }
}
