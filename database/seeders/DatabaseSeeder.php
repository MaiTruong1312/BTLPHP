<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobLocation;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create sample categories
        $categories = [
            ['name' => 'Information Technology', 'slug' => 'information-technology'],
            ['name' => 'Marketing', 'slug' => 'marketing'],
            ['name' => 'Sales', 'slug' => 'sales'],
            ['name' => 'Human Resources', 'slug' => 'human-resources'],
            ['name' => 'Finance', 'slug' => 'finance'],
            ['name' => 'Design', 'slug' => 'design'],
        ];

        foreach ($categories as $category) {
            JobCategory::create($category);
        }

        // Create sample locations
        $locations = [
            ['city' => 'Ho Chi Minh City', 'country' => 'Vietnam', 'slug' => 'ho-chi-minh-city'],
            ['city' => 'Hanoi', 'country' => 'Vietnam', 'slug' => 'hanoi'],
            ['city' => 'Da Nang', 'country' => 'Vietnam', 'slug' => 'da-nang'],
            ['city' => 'Can Tho', 'country' => 'Vietnam', 'slug' => 'can-tho'],
        ];

        foreach ($locations as $location) {
            JobLocation::create($location);
        }

        // Create sample skills
        $skills = [
            ['name' => 'PHP', 'slug' => 'php'],
            ['name' => 'Laravel', 'slug' => 'laravel'],
            ['name' => 'JavaScript', 'slug' => 'javascript'],
            ['name' => 'React', 'slug' => 'react'],
            ['name' => 'Vue.js', 'slug' => 'vuejs'],
            ['name' => 'MySQL', 'slug' => 'mysql'],
            ['name' => 'Git', 'slug' => 'git'],
            ['name' => 'Docker', 'slug' => 'docker'],
            ['name' => 'AWS', 'slug' => 'aws'],
            ['name' => 'SEO', 'slug' => 'seo'],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }

        // Create sample employer
        $employer = User::create([
            'name' => 'John Employer',
            'email' => 'employer@example.com',
            'password' => Hash::make('password'),
            'role' => 'employer',
        ]);

        $employerProfile = $employer->employerProfile()->create([
            'company_name' => 'Tech Solutions Inc.',
            'company_slug' => 'tech-solutions-inc',
            'about' => 'A leading technology company providing innovative solutions.',
            'company_size' => '51-200',
        ]);

        // Create sample candidate
        $candidate = User::create([
            'name' => 'Jane Candidate',
            'email' => 'candidate@example.com',
            'password' => Hash::make('password'),
            'role' => 'candidate',
        ]);

        $candidate->candidateProfile()->create([
            'phone' => '0123456789',
            'summary' => 'Experienced software developer with 5+ years in web development.',
            'years_of_experience' => 5,
        ]);

        // Create sample jobs
        $jobTitles = [
            'Senior PHP Developer',
            'Frontend Developer (React)',
            'Full Stack Developer',
            'Marketing Manager',
            'Sales Executive',
        ];

        $categoryIds = JobCategory::pluck('id')->toArray();
        $locationIds = JobLocation::pluck('id')->toArray();
        $skillIds = Skill::pluck('id')->toArray();

        foreach ($jobTitles as $index => $title) {
            $job = Job::create([
                'user_id' => $employer->id,
                'employer_profile_id' => $employerProfile->id,
                'category_id' => $categoryIds[array_rand($categoryIds)],
                'location_id' => $locationIds[array_rand($locationIds)],
                'title' => $title,
                'slug' => Str::slug($title) . '-' . time() . '-' . $index,
                'short_description' => 'We are looking for an experienced professional to join our team.',
                'description' => 'This is a detailed job description. We are seeking a talented individual who can contribute to our team and help us achieve our goals. The ideal candidate should have relevant experience and a passion for excellence.',
                'requirements' => 'Bachelor degree in related field. Minimum 2 years of experience. Strong communication skills.',
                'salary_min' => 10000000 + ($index * 2000000),
                'salary_max' => 20000000 + ($index * 3000000),
                'currency' => 'VND',
                'salary_type' => 'month',
                'job_type' => ['full_time', 'part_time', 'remote'][array_rand(['full_time', 'part_time', 'remote'])],
                'experience_level' => ['junior', 'mid', 'senior'][array_rand(['junior', 'mid', 'senior'])],
                'is_remote' => rand(0, 1),
                'vacancies' => rand(1, 3),
                'status' => 'published',
            ]);

            // Attach random skills
            $randomSkills = array_rand($skillIds, min(3, count($skillIds)));
            if (!is_array($randomSkills)) {
                $randomSkills = [$randomSkills];
            }
            $job->skills()->attach(array_map(fn($i) => $skillIds[$i], $randomSkills));
        }
    }
}
