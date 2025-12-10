<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CandidateExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('candidate_experiences')->insert([
            [
                'id' => 1, 'candidate_profile_id' => 1, 'company_name' => 'banking academy', 'position' => 'Back End', 'start_date' => '2020-12-31', 'end_date' => '2021-12-12', 'is_current' => 0, 'created_at' => '2025-11-23 11:21:14', 'updated_at' => '2025-11-24 17:40:07'
            ],
        ]);
    }
}