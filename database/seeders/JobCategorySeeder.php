<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('job_categories')->insert([
            ['id' => 1, 'name' => 'Information Technology', 'slug' => 'information-technology', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Marketing', 'slug' => 'marketing', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Sales', 'slug' => 'sales', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Human Resources', 'slug' => 'human-resources', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Finance', 'slug' => 'finance', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Design', 'slug' => 'design', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}