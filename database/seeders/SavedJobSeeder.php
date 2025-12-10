<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SavedJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('saved_jobs')->insert([
            ['user_id' => 3, 'job_id' => 2, 'saved_at' => '2025-11-25 23:09:54', 'updated_at' => '2025-11-25 23:09:54'],
            ['user_id' => 3, 'job_id' => 3, 'saved_at' => '2025-11-23 09:50:24', 'updated_at' => '2025-11-23 09:50:24'],
            ['user_id' => 3, 'job_id' => 4, 'saved_at' => '2025-11-25 23:10:04', 'updated_at' => '2025-11-25 23:10:04'],
            ['user_id' => 3, 'job_id' => 8, 'saved_at' => '2025-12-09 05:12:20', 'updated_at' => '2025-12-09 05:12:20'],
            ['user_id' => 5, 'job_id' => 3, 'saved_at' => '2025-11-29 23:38:17', 'updated_at' => '2025-11-29 23:38:17'],
        ]);
    }
}