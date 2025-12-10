<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CandidateSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('candidate_skill')->insert([
            ['candidate_profile_id' => 1, 'skill_id' => 1],
            ['candidate_profile_id' => 1, 'skill_id' => 3],
            ['candidate_profile_id' => 1, 'skill_id' => 11],
            ['candidate_profile_id' => 2, 'skill_id' => 3],
        ]);
    }
}