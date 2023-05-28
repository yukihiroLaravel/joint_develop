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
            'text' => 'テスト投稿ユーザー1',
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'text' => 'テスト投稿ユーザー2',
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'text' => 'テスト投稿ユーザー3',
        ]);
        DB::table('posts')->insert([
            'user_id' => 4,
            'text' => 'テスト投稿ユーザー4',
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'text' => 'テストtext5',
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'text' => 'text6',
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'text' => 'text7',
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'text' => 'text8',
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'text' => 'text9',
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'text' => 'text10',
        ]);
        DB::table('posts')->insert([
            'user_id' => 4,
            'text' => 'text11',
        ]);
    }
}
