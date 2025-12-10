<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CandidateProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('candidate_profiles')->insert([
            [
                'id' => 1, 'user_id' => 3, 'phone' => '0364335411', 'date_of_birth' => '2025-11-25', 'gender' => 'male', 'address' => '12 chua boc', 'summary' => 'Experienced software developer with 5+ years in web development.', 'years_of_experience' => 5, 'expected_salary_min' => 3000000, 'expected_salary_max' => 50000000, 'created_at' => '2025-11-21 09:01:55', 'updated_at' => '2025-11-24 17:38:42'
            ],
            [
                'id' => 2, 'user_id' => 5, 'phone' => '0364335411', 'date_of_birth' => '2025-11-25', 'address' => '12 chua boc', 'years_of_experience' => 5, 'expected_salary_min' => 3000000, 'expected_salary_max' => 50000000, 'created_at' => '2025-11-29 23:35:09', 'updated_at' => '2025-11-29 23:35:46'
            ],
            [
                'id' => 3, 'user_id' => 8, 'created_at' => '2025-12-05 09:19:34', 'updated_at' => '2025-12-05 09:19:34'
            ],
        ]);
    }
}