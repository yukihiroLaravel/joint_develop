<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ランダムなユーザーを１人選択
        $randomUser = User::inRandomOrder()->first();

        //最初の投稿のIDを取得
        $postId = DB::table('posts')->insertGetId([
            'user_id' => $randomUser->id,
            'content' => '新しいコメント',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $comments = [];
        for ($i = 1; $i <= 15; $i++) {
            $comments[] = [
                'user_id' => User::inRandomOrder()->first()->id, //ランダムなユーザーIDを取得
                'post_id' => $postId,
                'content' => '最初のコメントです' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('comments')->insert($comments);
    }
}
