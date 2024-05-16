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
        $seedMaxUser = 100; // 100人のユーザーが存在するため
        $posts = []; // 空配列を初期値として設定

        // 繰り返し処理で初期ポスト用の多次元配列を作成
        for ($userId = 1; $userId <= $seedMaxUser; $userId++) {
            for ($i = 1; $i <= 11; $i++) {
                $posts[] = [
                    'user_id' => $userId, // 1から100までのユーザーIDを割り当て
                    'content' => 'ユーザー' . $userId . 'の初期ポスト' . $i, // ユーザーごとの初期ポスト1〜11
                    'created_at' => now(), // 現在日時
                    'updated_at' => now() // 現在日時
                ];
            }
        }

        // データベースに投稿を挿入
        DB::table('posts')->insert($posts);
    }
}
