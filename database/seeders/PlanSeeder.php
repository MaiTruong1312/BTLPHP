<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->insert([
            [
                'id' => 1, 'name' => 'Basic', 'slug' => 'basic', 'price' => 0.00, 'features' => '{"post_jobs_limit":10,"can_search_cvs":false,"featured_jobs":0}', 'created_at' => '2025-12-02 22:21:32', 'updated_at' => '2025-12-02 22:21:32'
            ],
            [
                'id' => 2, 'name' => 'Standard', 'slug' => 'standard', 'price' => 499000.00, 'features' => '{"post_jobs_limit":20,"can_search_cvs":false,"featured_jobs":2}', 'created_at' => '2025-12-02 22:21:32', 'updated_at' => '2025-12-02 22:21:32'
            ],
            [
                'id' => 3, 'name' => 'Premium', 'slug' => 'premium', 'price' => 999000.00, 'features' => '{"post_jobs_limit":-1,"can_search_cvs":true,"featured_jobs":5}', 'created_at' => '2025-12-02 22:21:32', 'updated_at' => '2025-12-02 22:21:32'
            ],
        ]);
    }
}