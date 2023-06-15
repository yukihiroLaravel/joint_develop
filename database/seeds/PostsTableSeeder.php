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
            'text' => "テスト\n投稿1\nユーザ1",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'text' => "テスト\n投稿2\nユーザ2",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'text' => "テスト\n投稿3\nユーザ3",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 4,
            'text' => "テスト\n投稿4\nユーザ4",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'text' => "テスト\n投稿5\nユーザ1",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'text' => "テスト\n投稿6\nユーザ1",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'text' => "テスト\n投稿7\nユーザ2",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'text' => "テスト\n投稿8\nユーザ2",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'text' => "テスト\n投稿9\nユーザ3",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'text' => "テスト\n投稿10\nユーザ3",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 4,
            'text' => "テスト\n投稿11\nユーザ4",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
