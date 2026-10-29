<?php

use Illuminate\Database\Seeder;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = DB::table('posts')->select('id', 'user_id')->get();
        $userIds = DB::table('users')->pluck('id');

        if ($posts->isEmpty() || $userIds->isEmpty()) {
            $this->command->warn('No users or posts found. Please run UsersTableSeeder and PostsTableSeeder first.');
            return;
        }

        $likes = [];
        foreach ($posts as $index => $post) {
            // 投稿者以外のユーザの中から、投稿ごとに、いいね数が変わるように選ぶ
            $likers = $userIds->reject(function ($userId) use ($post) {
                return $userId == $post->user_id;
            })->values()->take($index % 4); // 0~3人

            foreach ($likers as $userId) {
                $likes[] = [
                    'user_id' => $userId,
                    'post_id' => $post->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('likes')->insert($likes);
    }
}
