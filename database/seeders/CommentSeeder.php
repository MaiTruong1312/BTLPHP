<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            ['id' => 1, 'job_id' => 1, 'user_id' => 3, 'content' => 'Job này rất hay nha', 'created_at' => '2025-11-27 21:57:26', 'updated_at' => '2025-11-27 21:57:26'],
            ['id' => 2, 'job_id' => 2, 'user_id' => 3, 'content' => 'React Hayyy nè', 'created_at' => '2025-11-27 22:50:32', 'updated_at' => '2025-11-27 22:50:32'],
            ['id' => 3, 'job_id' => 1, 'user_id' => 2, 'parent_id' => 1, 'content' => 'Bạn muốn ứng tuyển không?', 'created_at' => '2025-11-27 23:05:18', 'updated_at' => '2025-11-27 23:05:18'],
            ['id' => 4, 'job_id' => 1, 'user_id' => 2, 'parent_id' => 1, 'content' => 'Oke', 'created_at' => '2025-11-27 23:17:34', 'updated_at' => '2025-11-27 23:17:34'],
            ['id' => 5, 'job_id' => 1, 'user_id' => 2, 'parent_id' => 1, 'content' => 'hehe', 'created_at' => '2025-11-27 23:21:04', 'updated_at' => '2025-11-27 23:21:04'],
            ['id' => 6, 'job_id' => 7, 'user_id' => 4, 'content' => 'Mại dô mại dô', 'created_at' => '2025-11-28 09:14:03', 'updated_at' => '2025-11-28 09:14:03'],
            ['id' => 7, 'job_id' => 2, 'user_id' => 5, 'parent_id' => 2, 'content' => 'Thanks bạn', 'created_at' => '2025-11-30 01:57:18', 'updated_at' => '2025-11-30 01:57:18'],
            ['id' => 8, 'job_id' => 8, 'user_id' => 3, 'content' => 'Hi', 'created_at' => '2025-12-09 05:11:52', 'updated_at' => '2025-12-09 05:11:52'],
            ['id' => 9, 'job_id' => 8, 'user_id' => 2, 'parent_id' => 8, 'content' => 'Hi', 'created_at' => '2025-12-09 06:14:45', 'updated_at' => '2025-12-09 06:14:45'],
        ]);
    }
}