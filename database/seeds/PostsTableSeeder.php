<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'content' => '投稿の本文です。',
            'user_id' => 2
        ]);
        DB::table('posts')->insert([
            'content' => '投稿の本文です。',
            'user_id' => 1
        ]);
        DB::table('posts')->insert([
            'content' => '投稿の本文です。',
            'user_id' => 3
        ]);
        DB::table('posts')->insert([
            'content' => '投稿の本文です。',
            'user_id' => 4
        ]);
        DB::table('posts')->insert([
            'content' => '投稿の本文です。',
            'user_id' => 5
        ]);
        DB::table('posts')->insert([
            'content' => '投稿の本文です。',
            'user_id' => 6
        ]);
        DB::table('posts')->insert([
            'content' => '投稿の本文です。',
            'user_id' => 7
        ]);
        DB::table('posts')->insert([
            'content' => '投稿の本文です。',
            'user_id' => 8
        ]);
        DB::table('posts')->insert([
            'content' => '投稿の本文です。1',
            'user_id' => 1
        ]);
        DB::table('posts')->insert([
            'content' => '投稿の本文です。2',
            'user_id' => 2
        ]);
        DB::table('posts')->insert([
            'content' => '投稿の本文です。3',
            'user_id' => 3
        ]);
    }
}
