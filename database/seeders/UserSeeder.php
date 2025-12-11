<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
                'avatar' => 'avatars/692e8be107fbe.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Mai Truong',
                'email' => 'candidate@example.com',
                'password' => Hash::make('password'),
                'role' => 'candidate',
                'avatar' => 'avatars/6924fbcdaf955.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Sơn Quý',
                'email' => 'progamevip2310@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'employer',
                'avatar' => 'avatars/6929c9ab356fe.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'name' => 'Mai Văn Trường',
                'email' => 'goodjobem2@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'candidate',
                'avatar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'name' => 'Mai Văn Trường',
                'email' => 'maitruong1312205@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'employer',
                'avatar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'name' => 'Mai Văn Trường',
                'email' => 'a@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'employer',
                'avatar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'name' => 'Sơn Quý',
                'email' => '26a4041674@hvnh.edu.vn',
                'password' => Hash::make('password'),
                'role' => 'candidate',
                'avatar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Nếu bạn vẫn muốn tạo thêm user bằng factory
        User::factory()->create([
            'name' => 'Admin Factory',
            'email' => 'factory_admin@example.com',
            'role' => 'admin',
        ]);
    }
}
