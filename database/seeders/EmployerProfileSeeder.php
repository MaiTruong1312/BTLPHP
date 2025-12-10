<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployerProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employer_profiles')->insert([
            [
                'id' => 1, 'user_id' => 2, 'company_name' => 'Tech Solutions Inc.', 'company_slug' => 'tech-solutions-inc', 'company_size' => '51-200', 'about' => 'A leading technology company providing innovative solutions.', 'created_at' => '2025-11-21 09:01:55', 'updated_at' => '2025-11-21 09:01:55'
            ],
            [
                'id' => 2, 'user_id' => 4, 'company_name' => 'banking academy', 'company_slug' => 'banking-academy', 'created_at' => '2025-11-28 09:10:15', 'updated_at' => '2025-11-28 09:10:15'
            ],
            [
                'id' => 3, 'user_id' => 6, 'company_name' => 'BanKing Lion', 'company_slug' => 'banking-lion', 'created_at' => '2025-12-03 02:43:43', 'updated_at' => '2025-12-03 02:43:43'
            ],
            [
                'id' => 4, 'user_id' => 7, 'company_name' => 'Job Portal', 'company_slug' => 'job-portal', 'created_at' => '2025-12-05 04:56:10', 'updated_at' => '2025-12-05 04:56:10'
            ],
        ]);
    }
}