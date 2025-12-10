<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'avatar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'John Employer',
                'email' => 'employer@example.com',
                'password' => Hash::make('password'),
                'role' => 'employer',
                'avatar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Mai Truong',
                'email' => 'candidate@example.com',
                'password' => Hash::make('password'),
                'role' => 'candidate',
                'avatar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
