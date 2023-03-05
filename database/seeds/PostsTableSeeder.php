<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 1; $i++) {
        $date = new Carbon('2023-01-15 10:24:57');
        $date->addSecond();
        DB::table('posts')->insert([
            'user_id' => '1',
            'content' => 'はじめまして！呪術廻戦のオープニングもエンディングも劇場版0も全部良いのでアニメと共に見て欲しいです！',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        $date->addSecond($i+12345);
        DB::table('posts')->insert([
            'user_id' => '2',
            'content' => 'ef - a tale of memories/melodiesというアニメ是非オススメです。melodiesの方は、毎話OPが変わるので隙がありません！！',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        $date->addSecond($i+12345);
        DB::table('posts')->insert([
            'user_id' => '3',
            'content' => '「ひぐらしのなく頃に」ってゲームもアニメもいい曲いっぱいありますよね。',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        $date->addSecond($i+12345);
        DB::table('posts')->insert([
            'user_id' => '5',
            'content' => 'シュタインズゲートのOP「Hacking to the Gate」！アニメ面白いし、歌詞と内容がだんだん関連してきて、ラスト2話のOPは飛ばしちゃだめです。',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        $date->addSecond($i+12345);
        DB::table('posts')->insert([
            'user_id' => '4',
            'content' => 'シャドウハーツ２のED曲（月恋花）すごく良いんで聴いてみてください。諌山さんの歌声が染み入ります。',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        $date->addSecond($i+12345);
        DB::table('posts')->insert([
            'user_id' => '10',
            'content' => 'azumaさん。呪術廻戦、私も好きです！呪術廻戦0は3回も映画館に観にいっちゃいました。',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        $date->addSecond($i+12345);
        DB::table('posts')->insert([
            'user_id' => '3',
            'content' => 'イケやんさん、諌山さんの曲でプレイス・オブ・ピリオドって曲も染み入りますよ！',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        $date->addSecond($i+12345);
        DB::table('posts')->insert([
            'user_id' => '4',
            'content' => '品川さん聴いてみますね！オススメありがとうございます。',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        $date->addSecond($i+12345);
        DB::table('posts')->insert([
            'user_id' => '7',
            'content' => 'プラネテスのWonderful Lifeって曲好きです。アニメと一緒に聴いて欲しいなあ〜。エンディングの入り方が最高なんですよ☆',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        $date->addSecond($i+12345);
        DB::table('posts')->insert([
            'user_id' => '8',
            'content' => 'ターンAガンダムのMoon！壮大で聴き入っちゃいます。さすが菅野よう子さんです。',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        $date->addSecond($i+12345);
        DB::table('posts')->insert([
            'user_id' => '6',
            'content' => '初めまして。ちょっと昔のゲームなんですが、横スクロールアクションのリターン・オブ・ダブルドラゴンとコントラスピリッツのBGMが好きです。わかる人います？',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        $date->addSecond($i+12345);
        DB::table('posts')->insert([
            'user_id' => '2',
            'content' => 'BBさんMoon良いですね！自分はウイングガンダム好きです！！',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        $date->addSecond($i+12345);
        DB::table('posts')->insert([
            'user_id' => '9',
            'content' => 'アニメ映画「パプリカ」の主題歌好きです。不思議な内容と平沢進さんの独特の曲が合っててすごく良いんです。',
            'created_at' => $date,
            'updated_at' => $date
        ]);
    }
    }
}
