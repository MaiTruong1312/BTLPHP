<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('job_locations')->insert([
            ['id' => 1, 'city' => 'Ho Chi Minh City', 'country' => 'Vietnam', 'slug' => 'ho-chi-minh-city', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'city' => 'Hanoi', 'country' => 'Vietnam', 'slug' => 'hanoi', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'city' => 'Da Nang', 'country' => 'Vietnam', 'slug' => 'da-nang', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'city' => 'Can Tho', 'country' => 'Vietnam', 'slug' => 'can-tho', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}