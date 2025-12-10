<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('email_templates')->insert([
            [
                'id' => 1, 'user_id' => 2, 'name' => 'Phỏng vấn 1', 'subject' => 'Lịch hẹn phỏng vấn', 'body' => 'Bạn đã được chúng tôi ...', 'type' => 'interview', 'created_at' => '2025-11-30 01:13:19', 'updated_at' => '2025-11-30 01:13:19'
            ],
        ]);
    }
}