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
        DB::table('comments')->insert([
            'comment' => "「マーメイドのフルーツサラダ」のレシピ\n材料：\n・フェアリーブレッド：2個、切り分ける\n・マーメイドメロン：1個、種を取り除いて切り分ける\n・シルバーリーフ：適量\n・ムーンドロップ：数粒\n・フェアリーハニー：適量\n作り方：\n・フェアリーブレッドとマーメイドメロンを器に盛ります。\n・シルバーリーフを添え、ムーンドロップを散らします。\n・最後にフェアリーハニーをかけて完成です。",
            'post_id' => 1,
            'user_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "このレシピは本当に美味しそうですね！\n早速試してみます。\n他にもおすすめのレシピはありますか？",
            'post_id' => 1,
            'user_id' => 3,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "「スペシャルポーション」なんかもおススメですよ!!\n材料:\n・フェニックスの羽：1枚\n・スライムゼリー：適量\n・マジックビーンズ：10粒\n・ドラゴンの涙：少々\n作り方:\n・少し大きめのボウルにフェニックスの羽とスライムゼリーを入れます。\n・マジックビーンズを加え、ゆっくりとかき混ぜます。\n・最後に少量のドラゴンの涙を垂らし、ポーションが輝くようにします。\nめちゃくちゃ体力回復しますよ!!",
            'post_id' => 1,
            'user_id' => 4,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "このポーション知ってます!\n自分で作った方が安上がりだし、体力回復量が多いんですよね!!",
            'post_id' => 1,
            'user_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "コップにコーヒーの粉を入れてお湯を注ぐとコーヒーができますよ!!",
            'post_id' => 2,
            'user_id' => 3,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "こんなにおしゃれなカフェスタイルのドリンクが\n自宅で楽しめるなんて驚きました！\nぜひ挑戦してみます。",
            'post_id' => 2,
            'user_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "腹筋!!\n腕立て伏せ!!!\nスクワット!!!!\n以上!!!!!!",
            'post_id' => 3,
            'user_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "アルミホイルをクルクル指に巻いたら指輪になるよ!!",
            'post_id' => 4,
            'user_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "首に巻いたらネックレスにもなるよ!!",
            'post_id' => 4,
            'user_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "どれも素敵なアイデアですね！\n自宅で楽しく時間を過ごせそうです。\n他にもアイデアがあったら教えてください!!",
            'post_id' => 4,
            'user_id' => 3,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "掌田津耶乃さんの\n「PHPフレームワーク Laravel入門」\nがおすすめですよ！",
            'post_id' => 5,
            'user_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "確かによかった!\n入門としてはおススメですね!",
            'post_id' => 5,
            'user_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "人生\nそれは\nゲーム",
            'post_id' => 6,
            'user_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "深い・・・",
            'post_id' => 6,
            'user_id' => 3,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "自宅で映画マラソンをするのは最高ですよね！\nこれから観たい映画のリストを作ってきます!!\nまた今度シェアしますね!!",
            'post_id' => 8,
            'user_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "映画鑑賞には「マーメイドのフルーツサラダ」がおススメです！\nぜひ映画のお供にどうぞ!!",
            'post_id' => 8,
            'user_id' => 3,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "家も地獄なんですがどうしましょう？",
            'post_id' => 9,
            'user_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "ここでみんなが色々おススメしてくれてますよ!!\n自分は\nかめはめ波するとか結構いいと思いますね。",
            'post_id' => 9,
            'user_id' => 3,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "確かに・・・\n地獄から天国になりました。\n今まさに。",
            'post_id' => 9,
            'user_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "ありすぎて文字数こえてエラーになるんですが。\nありすぎますよね。",
            'post_id' => 10,
            'user_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "トイレです。",
            'post_id' => 11,
            'user_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "カーペットで大の字で寝転ぶ!!",
            'post_id' => 11,
            'user_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "お気に入りのソファー",
            'post_id' => 11,
            'user_id' => 3,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'comment' => "トイレです。",
            'post_id' => 11,
            'user_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
