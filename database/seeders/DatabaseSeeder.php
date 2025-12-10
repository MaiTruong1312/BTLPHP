<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            EmployerProfileSeeder::class,
            CandidateProfileSeeder::class,
            JobCategorySeeder::class,
            JobLocationSeeder::class,
            SkillSeeder::class,
            JobSeeder::class,
            JobSkillSeeder::class,
            CandidateSkillSeeder::class,
            CandidateEducationSeeder::class,
            CandidateExperienceSeeder::class,
            JobApplicationSeeder::class,
            CommentSeeder::class,
            PostSeeder::class,
            PlanSeeder::class,
            SubscriptionSeeder::class,
            EmailTemplateSeeder::class,
            SavedJobSeeder::class,
        ]);
    }
}