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
            'post_text' => 'テスト投稿１です',
        
         ]);
         DB::table('posts')->insert([
            'user_id' => 1,
            'post_text' => 'テスト投稿２です',
        
         ]);
         DB::table('posts')->insert([
            'user_id' => 1,
            'post_text' => 'テスト投稿３です',
         
         ]);
         DB::table('posts')->insert([
            'user_id' => 1,
            'post_text' => 'テスト投稿４です',
         
         ]);
    }
}
