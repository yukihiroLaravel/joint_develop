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
            'user_id' => 1,
            'content' => 'これはテスト投稿です。',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' => 'phpはわかりやすいプログラミング言語です。',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' => 'laravelはとても便利なフレームワークです。',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' => 'プログラミングは難しいが楽しい。',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}