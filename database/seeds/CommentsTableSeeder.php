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
        // 小さい順に3件分の投稿IDを取得
        $postIds = DB::table('posts')->orderBy('id')->limit(3)->pluck('id');

        foreach ($postIds as $postId) {
            // 1階層目: 投稿への返信
            $commentId = DB::table('comments')->insertGetId([
                'user_id' => 2,
                'post_id' => $postId,
                'parent_id' => null,
                'content' => "testcomment_投稿{$postId}への返信",
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2階層目: 返信への返信
            $replyId = DB::table('comments')->insertGetId([
                'user_id' => 3,
                'post_id' => $postId,
                'parent_id' => $commentId,
                'content' => "testcomment_投稿{$postId}_返信への返信",
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 3階層目: さらにその返信
            DB::table('comments')->insert([
                'user_id' => 1,
                'post_id' => $postId,
                'parent_id' => $replyId,
                'content' => "testcomment_投稿{$postId}_さらに返信",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
