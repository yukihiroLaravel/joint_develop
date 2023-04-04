<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'user_id' => 1,
            'text' => 'こちらはダミー投稿です。',
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'text' => 'こちらはダミー投稿です。',
        ]);

        DB::table('posts')->insert([
            'user_id' => 3,
            'text' => 'こちらはダミー投稿です。',
        ]);
        DB::table('posts')->insert([
            'user_id' => 4,
            'text' => 'こちらはダミー投稿です。',
        ]);
    }
}

