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
        $seedMaxUser = 4; // UsersTableSeederでは4件のレコードが作成される
        $posts = []; // 空配列を初期値として設定

        // 繰り返し処理で初期ポスト用の多次元配列を作成
        for ($i = 1; $i <= 30; $i++) {
            // 4で割り切ればい場合→余りの数値をuser_idに設定
            // 4で割り切れる場合→4をuser_idに設定
            $userId = ($i % $seedMaxUser !== 0) ? $i % $seedMaxUser : $seedMaxUser;
            $posts[] = [
                'user_id' => $userId, // 1〜4
                'content' => '初期ポスト' . $i, // 初期ポスト1〜30
                'created_at' => now(), // 現在日時
                'updated_at' => now() // 現在日時
            ];
        }

        // postsテーブルのシーダとして、30件のレコードを作成
        DB::table('posts')->insert($posts);
    }
}
