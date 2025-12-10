<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1, 'name' => 'Admin User', 'email' => 'admin@example.com', 'password' => Hash::make('password'), 'role' => 'admin', 'created_at' => '2025-11-21 09:01:55', 'updated_at' => '2025-11-21 09:01:55'
            ],
            [
                'id' => 2, 'name' => 'John Employer', 'email' => 'employer@example.com', 'password' => Hash::make('password'), 'role' => 'employer', 'avatar' => 'avatars/692e8be107fbe.jpg', 'created_at' => '2025-11-21 09:01:55', 'updated_at' => '2025-12-01 23:49:05'
            ],
            [
                'id' => 3, 'name' => 'Mai Truong', 'email' => 'candidate@example.com', 'password' => Hash::make('password'), 'role' => 'candidate', 'avatar' => 'avatars/6924fbcdaf955.jpg', 'created_at' => '2025-11-21 09:01:55', 'updated_at' => '2025-11-24 17:43:57'
            ],
            [
                'id' => 4, 'name' => 'Sơn Quý', 'email' => 'progamevip2310@gmail.com', 'password' => Hash::make('password'), 'role' => 'employer', 'avatar' => 'avatars/6929c9ab356fe.jpg', 'created_at' => '2025-11-28 09:10:15', 'updated_at' => '2025-11-28 09:11:24'
            ],
            [
                'id' => 5, 'name' => 'Mai Văn Trường', 'email' => 'goodjobem2@gmail.com', 'password' => Hash::make('password'), 'role' => 'candidate', 'created_at' => '2025-11-29 23:35:09', 'updated_at' => '2025-11-29 23:35:09'
            ],
            [
                'id' => 6, 'name' => 'Mai Văn Trường', 'email' => 'maitruong1312205@gmail.com', 'password' => Hash::make('password'), 'role' => 'employer', 'created_at' => '2025-12-03 02:43:43', 'updated_at' => '2025-12-03 02:43:43'
            ],
            [
                'id' => 7, 'name' => 'Mai Văn Trường', 'email' => 'a@gmail.com', 'password' => Hash::make('password'), 'role' => 'employer', 'created_at' => '2025-12-05 04:56:10', 'updated_at' => '2025-12-05 04:56:10'
            ],
            [
                'id' => 8, 'name' => 'Sơn Quý', 'email' => '26a4041674@hvnh.edu.vn', 'password' => Hash::make('password'), 'role' => 'candidate', 'created_at' => '2025-12-05 09:19:34', 'updated_at' => '2025-12-05 09:19:34'
            ],
        ]);
    }
}