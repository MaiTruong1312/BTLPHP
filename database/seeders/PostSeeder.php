<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            [
                'id' => 1, 'user_id' => 1, 'title' => 'The Future of Remote Work', 'slug' => 'the-future-of-remote-work', 'content' => 'The COVID-19 pandemic has accelerated the trend of remote work. In this post, we explore the future of remote work and what it means for both employees and employers. We will look at the benefits, challenges, and the tools needed to succeed in a remote-first world.', 'status' => 'published', 'published_at' => '2025-11-16 08:02:28', 'created_at' => '2025-11-26 08:02:28', 'updated_at' => '2025-11-26 08:02:28'
            ],
            [
                'id' => 2, 'user_id' => 1, 'title' => 'Top 10 In-Demand Skills for 2025', 'slug' => 'top-10-in-demand-skills-for-2025', 'content' => 'The job market is constantly evolving. To stay competitive, it\'s crucial to know which skills are in high demand. This article breaks down the top 10 skills that employers will be looking for in 2025, from AI and machine learning to soft skills like emotional intelligence.', 'status' => 'published', 'published_at' => '2025-11-21 08:02:28', 'created_at' => '2025-11-26 08:02:28', 'updated_at' => '2025-11-26 08:02:28'
            ],
            [
                'id' => 3, 'user_id' => 1, 'title' => 'How to Ace Your Next Job Interview', 'slug' => 'how-to-ace-your-next-job-interview', 'content' => 'Job interviews can be stressful. Preparation is key to success. In this guide, we provide tips and tricks on how to prepare for your next interview, from researching the company to practicing common interview questions and following up afterward.', 'status' => 'published', 'published_at' => '2025-11-24 08:02:28', 'created_at' => '2025-11-26 08:02:28', 'updated_at' => '2025-11-26 08:02:28'
            ],
            [
                'id' => 4, 'user_id' => 1, 'title' => 'Crafting the Perfect Resume', 'slug' => 'crafting-the-perfect-resume', 'content' => 'Your resume is your first impression. A well-crafted resume can open doors to new opportunities. This post offers a step-by-step guide to writing a resume that stands out, including choosing the right format, highlighting your achievements, and tailoring it to the job description.', 'status' => 'draft', 'created_at' => '2025-11-26 08:02:28', 'updated_at' => '2025-11-26 08:02:28'
            ],
            [
                'id' => 5, 'user_id' => 4, 'title' => 'Test', 'slug' => 'test', 'content' => 'Tôi đang trải nghiệm việc code php bằng famework laravel', 'status' => 'published', 'published_at' => '2025-11-28 16:14:00', 'created_at' => '2025-11-28 09:15:39', 'updated_at' => '2025-11-28 09:15:39'
            ],
            [
                'id' => 6, 'user_id' => 2, 'title' => 'Test Xem ảnh được không', 'slug' => 'test-xem-anh-duoc-khong', 'content' => 'Test', 'status' => 'published', 'published_at' => '2025-12-02 06:34:00', 'created_at' => '2025-12-01 23:34:15', 'updated_at' => '2025-12-01 23:34:15'
            ],
        ]);
    }
}