<?php

namespace Database\Seeders;

use Database\Seeders\PostSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(PostSeeder::class);
    }
}
