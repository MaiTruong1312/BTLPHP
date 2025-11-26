<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get an admin or employer user to be the author of the posts
        $user = User::where('role', 'admin')->first();

        if (!$user) {
            $user = User::where('role', 'employer')->first();
        }

        // If no admin or employer, we can't create posts
        if (!$user) {
            $this->command->info('No admin or employer user found to create posts.');
            return;
        }

        $posts = [
            [
                'title' => 'The Future of Remote Work',
                'content' => 'The COVID-19 pandemic has accelerated the trend of remote work. In this post, we explore the future of remote work and what it means for both employees and employers. We will look at the benefits, challenges, and the tools needed to succeed in a remote-first world.',
                'status' => 'published',
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Top 10 In-Demand Skills for 2025',
                'content' => 'The job market is constantly evolving. To stay competitive, it\'s crucial to know which skills are in high demand. This article breaks down the top 10 skills that employers will be looking for in 2025, from AI and machine learning to soft skills like emotional intelligence.',
                'status' => 'published',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'How to Ace Your Next Job Interview',
                'content' => 'Job interviews can be stressful. Preparation is key to success. In this guide, we provide tips and tricks on how to prepare for your next interview, from researching the company to practicing common interview questions and following up afterward.',
                'status' => 'published',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Crafting the Perfect Resume',
                'content' => 'Your resume is your first impression. A well-crafted resume can open doors to new opportunities. This post offers a step-by-step guide to writing a resume that stands out, including choosing the right format, highlighting your achievements, and tailoring it to the job description.',
                'status' => 'draft',
                'published_at' => null,
            ],
        ];

        foreach ($posts as $postData) {
            Post::create([
                'user_id' => $user->id,
                'title' => $postData['title'],
                'slug' => Str::slug($postData['title']),
                'content' => $postData['content'],
                'status' => $postData['status'],
                'published_at' => $postData['published_at'],
            ]);
        }
    }
}
