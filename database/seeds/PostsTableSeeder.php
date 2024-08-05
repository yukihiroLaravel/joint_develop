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
            'content' => 'ディズニー最高！',
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'content' => 'ラプンツェル可愛かったね！',
            'user_id' => 2,
        ]);
        DB::table('posts')->insert([
            'content' => 'ランドって時計回りに周りに‘過去’‘現在’‘未来’になってるんだって！',
            'user_id' => 3,
        ]);
        DB::table('posts')->insert([
            'content' => '11月18日はミッキーの誕生日だよ！',
            'user_id' => 4,
        ]);
        DB::table('posts')->insert([
            'content' => 'シーの夜景綺麗すぎ！',
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'content' => 'キャラメルポップコーンが一番好き！',
            'user_id' => 2,
        ]);
        DB::table('posts')->insert([
            'content' => 'タワテラ怖すぎ！シリキ・ウトゥンドゥの目が・・・',
            'user_id' => 3,
        ]);
        DB::table('posts')->insert([
            'content' => 'やばーい！ソアリン100分待ち(泣)',
            'user_id' => 4,
        ]);
        DB::table('posts')->insert([
            'content' => '新アトラクション楽しすぎ！！',
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'content' => 'ランドでもお酒飲めるようになったよ！',
            'user_id' => 2,
        ]);
        DB::table('posts')->insert([
            'content' => 'スプラッシュマウンテンのカメラは右側にあるよ！',
            'user_id' => 3,
        ]);
    }
}
