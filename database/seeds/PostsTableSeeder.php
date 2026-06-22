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
            'content' => 'テスト投稿１です',
        ]);
         DB::table('posts')->insert([
            'user_id' => 1,
            'content' => 'テスト投稿２です',
         ]);
         DB::table('posts')->insert([
            'user_id' => 1,
            'content' => 'テスト投稿３です',
         ]);
         DB::table('posts')->insert([
            'user_id' => 2,
            'content' => 'テスト投稿４です',
         ]);
         DB::table('posts')->insert([
            'user_id' => 2,
            'content' => 'テスト投稿５です',
        ]);
         DB::table('posts')->insert([
            'user_id' => 2,
            'content' => 'テスト投稿６です',
         ]);
         DB::table('posts')->insert([
            'user_id' => 3,
            'content' => 'テスト投稿７です',
         ]);
         DB::table('posts')->insert([
            'user_id' => 3,
            'content' => 'テスト投稿８です',
         ]);
         DB::table('posts')->insert([
            'user_id' => 3,
            'content' => 'テスト投稿９です',
        ]);
         DB::table('posts')->insert([
            'user_id' => 4,
            'content' => 'テスト投稿１０です',
         ]);
         DB::table('posts')->insert([
            'user_id' => 4,
            'content' => 'テスト投稿１１です',
         ]);
         DB::table('posts')->insert([
            'user_id' => 4,
            'content' => 'テスト投稿１２です',
         ]);
    }
}
