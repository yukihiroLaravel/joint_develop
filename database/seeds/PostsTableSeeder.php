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
            'text' => "家庭料理のレシピをシェアしよう！\n手軽にできる料理やスイーツを\n写真や手順を添えてシェアしませんか？",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'text' => "おうちカフェの楽しみ方！\n自宅でも本格的なコーヒーや紅茶を楽しめる!!\nおしゃれなドリンクレシピなどシェアしよう!!",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'text' => "家にいたら体もなまる…。\n自宅で手軽にできるエクササイズやストレッチは？\n日々のルーティンなども共有して\n健康的な生活を提案しませんか？",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 4,
            'text' => "やっぱりDIYでしょ!\nおうち時間をもっと楽しくできる!!\n手作りアクセサリー\nインテリアデコレーションなどなど",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'text' => "家ですること!やっぱり読書でしょ？\nおすすめの本はもちろん\n自分の心地よい読書ポジションは？\n読書に関する事ならなんでも共有だ!!",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'text' => "おうち時間＝ゲーム時間\nゲームに関することならなんでもコイコイ!!\nボードゲームでもアプリゲームでもテレビゲームでも!!",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'text' => "家でもイベントに参加できちゃう？！\n自宅でまったりオンラインイベントに参加しちゃってます。\n家でもコンサートやワークショップなど\nイベントに参加してる人集まれー\nおすすめイベントありませんかー？",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'text' => "家ですること、映画鑑賞以外ないでしょ？\nおすすめ映画シェアしましょ!!\n映画マラソンしてますか？\n映画のお供はやっぱりこのスナックでしょ？的な？",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'text' => "外は地獄だ…家にずっといたいぜ…。\n地獄の疲れを癒す、ストレス解消法、リラックス法を伝授",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'text' => "今おすすめのアニメはこれ!!\n過去一のアニメはこれ!!\nこれから来るアニメはこれ!!生の全てはアニメでしょ？！",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 4,
            'text' => "おうちの一番落ち着く場所。\nおうちで一番落ち着く方法。\nおうちでの一番をシェアするよ!!",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
