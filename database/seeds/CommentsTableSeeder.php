<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            'comment' => "テストコメント\nユーザー1\nポスト1",
            'post_id' => 1,
            'user_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "テストコメント\nユーザー2\nポスト2",
            'post_id' => 2,
            'user_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "テストコメント\nユーザー3\nポスト3",
            'post_id' => 3,
            'user_id' => 3,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "テストコメント\nユーザー4\nポスト4",
            'post_id' => 4,
            'user_id' => 4,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "テストコメント\nユーザー1\nポスト5",
            'post_id' => 5,
            'user_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "テストコメント\nユーザー1\nポスト6",
            'post_id' => 6,
            'user_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "テストコメント\nユーザー1\nポスト7",
            'post_id' => 7,
            'user_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "テストコメント\nユーザー1\nポスト8",
            'post_id' => 8,
            'user_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "テストコメント\nユーザー1\nポスト9",
            'post_id' => 9,
            'user_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "テストコメント\nユーザー1\nポスト10",
            'post_id' => 10,
            'user_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "テストコメント\nユーザー2\nポスト10",
            'post_id' => 10,
            'user_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "テストコメント\nユーザー1\nポスト11",
            'post_id' => 11,
            'user_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "テストコメント\nユーザー2\nポスト11",
            'post_id' => 11,
            'user_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
