<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('job_applications')->insert([
            [
                'id' => 3, 'job_id' => 2, 'user_id' => 3, 'candidate_profile_id' => 1, 'cover_letter' => 'Tôi muốn ứng tuyển', 'cv_path' => 'cvs/lTzUobTngx8jU1gycTjKzLUdlbHJK0WdZK3lsGnE.pdf', 'status' => 'rejected', 'applied_at' => '2025-11-30 03:36:08', 'created_at' => '2025-11-30 03:36:08'
            ],
            [
                'id' => 4, 'job_id' => 7, 'user_id' => 3, 'candidate_profile_id' => 1, 'cover_letter' => 'Tôi muốn ứng tuyển', 'cv_path' => 'cvs/mHo0O5arNTZflmZLm9HbCmDDEiGD6NHdiEW7C9cm.pdf', 'status' => 'applied', 'applied_at' => '2025-11-30 05:32:56', 'created_at' => '2025-11-30 05:32:56'
            ],
            [
                'id' => 5, 'job_id' => 5, 'user_id' => 3, 'candidate_profile_id' => 1, 'cover_letter' => 'Tôi muốn ứng tuyển', 'cv_path' => 'cvs/L9lje3q1AML1tG8U7E0jdHigojF6MTHxvgsgmrtC.pdf', 'status' => 'interview', 'applied_at' => '2025-11-30 05:35:51', 'created_at' => '2025-11-30 05:35:51'
            ],
            [
                'id' => 6, 'job_id' => 7, 'user_id' => 5, 'candidate_profile_id' => 2, 'cover_letter' => 'Heheeeee', 'cv_path' => 'cvs/zCTHseMKBK4tZQFnW0actm1gFxQsZOWjIC78Uh23.pdf', 'status' => 'applied', 'applied_at' => '2025-11-30 06:36:30', 'created_at' => '2025-11-30 06:36:30'
            ],
            [
                'id' => 7, 'job_id' => 3, 'user_id' => 5, 'candidate_profile_id' => 2, 'cover_letter' => 'Tôi muốn ứng tuyển', 'cv_path' => 'cvs/0T40ANjzNULfq7AMnK9drkzCIfbUxZeCglMnSqgv.pdf', 'status' => 'interview', 'notes' => 'Có yếu tố tốt', 'applied_at' => '2025-11-30 06:38:32', 'created_at' => '2025-11-30 06:38:32'
            ],
            [
                'id' => 8, 'job_id' => 1, 'user_id' => 3, 'candidate_profile_id' => 1, 'cover_letter' => 'Tôi muốn ứng tuyển', 'cv_path' => 'cvs/ZqD2UkoEwY6QBwqZTqS3lYuEUYVzB6ygnd5BU1wG.pdf', 'status' => 'interview', 'applied_at' => '2025-11-30 08:39:31', 'created_at' => '2025-11-30 08:39:31'
            ],
            [
                'id' => 9, 'job_id' => 2, 'user_id' => 5, 'candidate_profile_id' => 2, 'cover_letter' => 'Tôi muốn ứng tuyển', 'status' => 'interview', 'applied_at' => '2025-11-30 08:57:36', 'created_at' => '2025-11-30 08:57:36'
            ],
            [
                'id' => 10, 'job_id' => 4, 'user_id' => 3, 'candidate_profile_id' => 1, 'cover_letter' => 'Hú Hú', 'cv_path' => 'cvs/dGnY4aAJo17dzG6V9ZJC9jY3FXtYnp4U130N8Xey.pdf', 'status' => 'interview', 'applied_at' => '2025-11-30 09:13:12', 'created_at' => '2025-11-30 09:13:12'
            ],
            [
                'id' => 11, 'job_id' => 8, 'user_id' => 3, 'candidate_profile_id' => 1, 'cover_letter' => 'Tôi muốn ứng tuyển', 'cv_path' => 'cvs/oy0j1uNRbsad3i8duTs1jAjpjKDsfCwPUwnjPXxQ.pdf', 'status' => 'applied', 'applied_at' => '2025-12-09 12:12:17', 'created_at' => '2025-12-09 12:12:17'
            ],
        ]);
    }
}