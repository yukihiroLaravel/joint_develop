<?php

use Illuminate\Database\Seeder;
use App\Comment;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 30; $i++) {
            Comment::create([
                'user_id'    => mt_rand(1, 4),
                'post_id'    => mt_rand(1, 10),
                'body'       => 'これはお題への回答のテスト投稿' . $i,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
