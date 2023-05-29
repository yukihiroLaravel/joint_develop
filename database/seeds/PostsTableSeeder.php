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
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'text' => 'テスト投稿ユーザー2',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'text' => 'テスト投稿ユーザー3',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 4,
            'text' => 'テスト投稿ユーザー4',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'text' => 'テストtext5',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'text' => 'text6',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'text' => 'text7',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'text' => 'text8',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'text' => 'text9',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'text' => 'text10',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 4,
            'text' => 'text11',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
