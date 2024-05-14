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
        $seedMaxUser = 100; // 4から100に変更、100人のユーザーが存在するため
        $posts = []; // 空配列を初期値として設定

        // 繰り返し処理で初期ポスト用の多次元配列を作成
        for ($i = 1; $i <= 100; $i++) { // 30回から100回に変更、100件の投稿を生成
            // ユーザーIDを割り算の余りで計算
            $userId = ($i % $seedMaxUser !== 0) ? $i % $seedMaxUser : $seedMaxUser;
            $posts[] = [
                'user_id' => $userId, // 1から100までのユーザーIDを割り当て
                'content' => '初期ポスト' . $i, // 初期ポスト1〜30
                'created_at' => now(), // 現在日時
                'updated_at' => now() // 現在日時
            ];
        }

        // データベースに投稿を挿入
        DB::table('posts')->insert($posts);
    }
}
