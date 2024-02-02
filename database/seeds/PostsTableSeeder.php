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
            'title' => 'テスト投稿1',
            'content' => 'テスト投稿です。',
        ]);

        DB::table('posts')->insert([
            'title' => 'テスト投稿2',
            'content' => 'テスト２の投稿です。',
        ]);

    }
}
