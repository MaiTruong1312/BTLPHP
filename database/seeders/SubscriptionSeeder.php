<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionSeeder extends Seeder
{
    public function run()
    {
        DB::table('subscriptions')->insert([
            [
                'id' => 1,
                'employer_profile_id' => 1,
                'plan_id' => 1,
                'starts_at' => '2025-12-02 22:21:43',
                'ends_at' => null,  // FIX
                'created_at' => '2025-12-02 22:21:43',
                'updated_at' => '2025-12-02 22:21:43'
            ],
            [
                'id' => 2,
                'employer_profile_id' => 1,
                'plan_id' => 3,
                'starts_at' => '2025-12-02 22:22:33',
                'ends_at' => '2026-01-02 22:22:33',
                'created_at' => '2025-12-02 22:22:33',
                'updated_at' => '2025-12-02 22:22:33'
            ],
            [
                'id' => 3,
                'employer_profile_id' => 1,
                'plan_id' => 2,
                'starts_at' => '2025-12-02 22:22:44',
                'ends_at' => '2026-01-02 22:22:44',
                'created_at' => '2025-12-02 22:22:44',
                'updated_at' => '2025-12-02 22:22:44'
            ],
            [
                'id' => 4,
                'employer_profile_id' => 3,
                'plan_id' => 1,
                'starts_at' => '2025-12-03 02:48:38',
                'ends_at' => null,  // FIX
                'created_at' => '2025-12-03 02:48:38',
                'updated_at' => '2025-12-03 02:48:38'
            ],
            [
                'id' => 5,
                'employer_profile_id' => 4,
                'plan_id' => 1,
                'starts_at' => '2025-12-05 04:56:48',
                'ends_at' => null,  // FIX
                'created_at' => '2025-12-05 04:56:46',
                'updated_at' => '2025-12-05 04:56:48'
            ],
        ]);
    }
}
