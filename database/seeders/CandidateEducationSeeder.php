<?php

namespace Database\Seeders;

use App\Models\CandidateProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CandidateEducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $candidateProfile = CandidateProfile::first();

        if ($candidateProfile) {
            DB::table('candidate_education')->insert([
                [
                    'id' => 1, 'candidate_profile_id' => $candidateProfile->id, 'school_name' => 'Banking Academy', 'degree' => '2027', 'field_of_study' => 'Tôi đã phải trải qua nhiều thứ mà không ai biết :)))', 'start_date' => '2023-11-25', 'end_date' => '2025-11-25', 'created_at' => '2025-11-24 17:45:15', 'updated_at' => '2025-11-24 17:45:15'
                ],
            ]);
        }
    }
}