<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    public function run()
    {
        DB::table('posts')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'title' => 'The Future of Remote Work',
                'slug' => 'the-future-of-remote-work',
                'content' => 'The COVID-19 pandemic has accelerated the trend of remote work...',
                'status' => 'published',
                'published_at' => '2025-11-16 08:02:28',
                'created_at' => '2025-11-26 08:02:28',
                'updated_at' => '2025-11-26 08:02:28'
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'title' => 'Top 10 In-Demand Skills for 2025',
                'slug' => 'top-10-in-demand-skills-for-2025',
                'content' => 'The job market is constantly evolving...',
                'status' => 'published',
                'published_at' => '2025-11-21 08:02:28',
                'created_at' => '2025-11-26 08:02:28',
                'updated_at' => '2025-11-26 08:02:28'
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'title' => 'How to Ace Your Next Job Interview',
                'slug' => 'how-to-ace-your-next-job-interview',
                'content' => 'Job interviews can be stressful...',
                'status' => 'published',
                'published_at' => '2025-11-24 08:02:28',
                'created_at' => '2025-11-26 08:02:28',
                'updated_at' => '2025-11-26 08:02:28'
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'title' => 'Crafting the Perfect Resume',
                'slug' => 'crafting-the-perfect-resume',
                'content' => 'Your resume is your first impression...',
                'status' => 'draft',
                'published_at' => null,   // <-- FIX QUAN TRỌNG
                'created_at' => '2025-11-26 08:02:28',
                'updated_at' => '2025-11-26 08:02:28'
            ],
            [
                'id' => 5,
                'user_id' => 4,
                'title' => 'Test',
                'slug' => 'test',
                'content' => 'Tôi đang trải nghiệm việc code php bằng famework laravel',
                'status' => 'published',
                'published_at' => '2025-11-28 16:14:00',
                'created_at' => '2025-11-28 09:15:39',
                'updated_at' => '2025-11-28 09:15:39'
            ],
            [
                'id' => 6,
                'user_id' => 2,
                'title' => 'Test Xem ảnh được không',
                'slug' => 'test-xem-anh-duoc-khong',
                'content' => 'Test',
                'status' => 'published',
                'published_at' => '2025-12-02 06:34:00',
                'created_at' => '2025-12-01 23:34:15',
                'updated_at' => '2025-12-01 23:34:15'
            ],
        ]);
    }
}
