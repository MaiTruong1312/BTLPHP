<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jobs')->insert([
            [
                'id' => 1, 'user_id' => 2, 'employer_profile_id' => 1, 'category_id' => 6, 'location_id' => 2, 'title' => 'Senior PHP Developer', 'slug' => 'senior-php-developer-1763740915-0', 'short_description' => 'We are looking for an experienced professional to join our team.', 'description' => 'This is a detailed job description. We are seeking a talented individual who can contribute to our team and help us achieve our goals. The ideal candidate should have relevant experience and a passion for excellence.', 'requirements' => 'Bachelor degree in related field. Minimum 2 years of experience. Strong communication skills.', 'salary_min' => 10000000, 'salary_max' => 20000000, 'job_type' => 'full_time', 'experience_level' => 'senior', 'is_remote' => 1, 'vacancies' => 2, 'status' => 'published', 'views_count' => 49, 'created_at' => '2025-11-21 09:01:55', 'updated_at' => '2025-12-01 07:48:06'
            ],
            [
                'id' => 2, 'user_id' => 2, 'employer_profile_id' => 1, 'category_id' => 2, 'location_id' => 4, 'title' => 'Frontend Developer (React)', 'slug' => 'frontend-developer-react-1763740915-1', 'short_description' => 'We are looking for an experienced professional to join our team.', 'description' => 'This is a detailed job description. We are seeking a talented individual who can contribute to our team and help us achieve our goals. The ideal candidate should have relevant experience and a passion for excellence.', 'requirements' => 'Bachelor degree in related field. Minimum 2 years of experience. Strong communication skills.', 'salary_min' => 12000000, 'salary_max' => 23000000, 'job_type' => 'remote', 'experience_level' => 'senior', 'is_remote' => 1, 'vacancies' => 1, 'status' => 'published', 'views_count' => 43, 'created_at' => '2025-11-21 09:01:55', 'updated_at' => '2025-12-01 23:36:29'
            ],
            [
                'id' => 3, 'user_id' => 2, 'employer_profile_id' => 1, 'category_id' => 6, 'location_id' => 1, 'title' => 'Full Stack Developer', 'slug' => 'full-stack-developer-1763740915-2', 'short_description' => 'We are looking for an experienced professional to join our team.', 'description' => 'This is a detailed job description. We are seeking a talented individual who can contribute to our team and help us achieve our goals. The ideal candidate should have relevant experience and a passion for excellence.', 'requirements' => 'Bachelor degree in related field. Minimum 2 years of experience. Strong communication skills.', 'salary_min' => 14000000, 'salary_max' => 26000000, 'job_type' => 'full_time', 'experience_level' => 'senior', 'is_remote' => 0, 'vacancies' => 3, 'status' => 'published', 'views_count' => 21, 'created_at' => '2025-11-21 09:01:55', 'updated_at' => '2025-12-07 08:54:37'
            ],
            [
                'id' => 4, 'user_id' => 2, 'employer_profile_id' => 1, 'category_id' => 2, 'location_id' => 1, 'title' => 'Marketing Manager', 'slug' => 'marketing-manager-1763740915-3', 'short_description' => 'We are looking for an experienced professional to join our team.', 'description' => 'This is a detailed job description. We are seeking a talented individual who can contribute to our team and help us achieve our goals. The ideal candidate should have relevant experience and a passion for excellence.', 'requirements' => 'Bachelor degree in related field. Minimum 2 years of experience. Strong communication skills.', 'salary_min' => 16000000, 'salary_max' => 29000000, 'job_type' => 'full_time', 'experience_level' => 'junior', 'is_remote' => 0, 'vacancies' => 3, 'status' => 'published', 'views_count' => 8, 'created_at' => '2025-11-21 09:01:55', 'updated_at' => '2025-12-01 07:49:05'
            ],
            [
                'id' => 5, 'user_id' => 2, 'employer_profile_id' => 1, 'category_id' => 1, 'location_id' => 3, 'title' => 'Sales Executive', 'slug' => 'sales-executive-1763740915-4', 'short_description' => 'We are looking for an experienced professional to join our team.', 'description' => 'This is a detailed job description. We are seeking a talented individual who can contribute to our team and help us achieve our goals. The ideal candidate should have relevant experience and a passion for excellence.', 'requirements' => 'Bachelor degree in related field. Minimum 2 years of experience. Strong communication skills.', 'salary_min' => 18000000, 'salary_max' => 32000000, 'job_type' => 'remote', 'experience_level' => 'senior', 'is_remote' => 1, 'vacancies' => 2, 'status' => 'published', 'views_count' => 4, 'created_at' => '2025-11-21 09:01:55', 'updated_at' => '2025-11-30 02:12:56'
            ],
            [
                'id' => 6, 'user_id' => 2, 'employer_profile_id' => 1, 'category_id' => 1, 'location_id' => 1, 'title' => 'Lập trình PHP', 'slug' => 'lap-trinh-php-1764039828', 'short_description' => 'Thành thạo PHP', 'description' => 'a', 'requirements' => 'a', 'salary_min' => 30000000, 'salary_max' => 50000000, 'job_type' => 'full_time', 'vacancies' => 1, 'deadline' => '2025-11-27', 'status' => 'published', 'views_count' => 8, 'created_at' => '2025-11-24 20:03:48', 'updated_at' => '2025-12-03 02:04:27'
            ],
            [
                'id' => 7, 'user_id' => 4, 'employer_profile_id' => 2, 'category_id' => 1, 'location_id' => 2, 'title' => 'Lập trình Java', 'slug' => 'lap-trinh-java-1764346429', 'short_description' => 'Sử dụng thành thạo Java', 'description' => 'Code được các dự án java lớn cùng với team hoàn thiện các chương trình', 'salary_min' => 5000000, 'salary_max' => 15000000, 'job_type' => 'internship', 'experience_level' => 'mid', 'is_remote' => 0, 'vacancies' => 2, 'deadline' => '2025-12-06', 'status' => 'published', 'views_count' => 14, 'created_at' => '2025-11-28 09:13:49', 'updated_at' => '2025-12-01 08:59:30'
            ],
            [
                'id' => 8, 'user_id' => 2, 'employer_profile_id' => 1, 'category_id' => 1, 'location_id' => 2, 'title' => 'Tuyển cộng tác viên React', 'slug' => 'tuyen-cong-tac-vien-react-1764752855', 'short_description' => 'Công việc mà chúng tôi đang cần', 'description' => 'Chạy deadline vui vẻ', 'requirements' => 'Thành thạo các ngôn ngữ liên quan', 'salary_min' => 10000000, 'salary_max' => 30000000, 'job_type' => 'remote', 'experience_level' => 'mid', 'is_remote' => 0, 'vacancies' => 2, 'deadline' => '2025-12-31', 'status' => 'published', 'views_count' => 9, 'created_at' => '2025-12-03 02:07:35', 'updated_at' => '2025-12-09 06:14:46'
            ],
            [
                'id' => 11, 'user_id' => 2, 'employer_profile_id' => 1, 'category_id' => 1, 'location_id' => 2, 'title' => 'Tuyển Intern PHP', 'slug' => 'tuyen-intern-php-1765284111', 'short_description' => 'Công việc mà chúng tôi đang cần', 'description' => 'Giới thiệu công việc:..............................', 'requirements' => 'Yêu cầu về công việc:,....................................', 'salary_min' => 10000000, 'salary_max' => 30000000, 'job_type' => 'internship', 'experience_level' => 'junior', 'is_remote' => 0, 'vacancies' => 4, 'deadline' => '2025-12-31', 'status' => 'published', 'views_count' => 0, 'created_at' => '2025-12-09 05:41:51', 'updated_at' => '2025-12-09 05:45:53'
            ],
        ]);
    }
}