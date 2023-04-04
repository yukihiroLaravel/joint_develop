<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        DB::table('postss')->insert([
            'user_id' => 1,
            'text' => 'こちらはダミー投稿です。',
        ]);
        DB::table('postss')->insert([
            'user_id' => 2,
            'text' => 'こちらはダミー投稿です。',
        ]);

        DB::table('postss')->insert([
            'user_id' => 3,
            'text' => 'こちらはダミー投稿です。',
        ]);
        DB::table('postss')->insert([
            'user_id' => 4,
            'text' => 'こちらはダミー投稿です。',
        ]);
    }
}

