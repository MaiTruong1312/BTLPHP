<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skills')->insert([
            ['id' => 1, 'name' => 'PHP', 'slug' => 'php', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Laravel', 'slug' => 'laravel', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'JavaScript', 'slug' => 'javascript', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'React', 'slug' => 'react', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Vue.js', 'slug' => 'vuejs', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'MySQL', 'slug' => 'mysql', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'Git', 'slug' => 'git', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'Docker', 'slug' => 'docker', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'name' => 'AWS', 'slug' => 'aws', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'name' => 'SEO', 'slug' => 'seo', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'name' => 'Marketing', 'slug' => 'marketing', 'created_at' => '2025-12-09 05:34:18', 'updated_at' => '2025-12-09 05:34:18'],
        ]);
    }
}