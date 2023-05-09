<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        // for ($i = 1; $i <= 15; $i++) {
        //     Post::create([
        //         'user_id' => mt_rand(1, 5),
        //         'text' => 'テスト投稿です'. $i,
        //     ]);
        // }

        DB::table('posts')->insert([
            'text' => '群馬県在住、幅広い麺が特徴の群馬県桐生市の名物「ひもかわうどん」がオススメ！！',
            'user_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('posts')->insert([
            'text' => '北海道在住、北海道グルメ①【海鮮】、札幌駅から徒歩圏内「二条市場」！！',
            'user_id' => '2',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('posts')->insert([
            'text' => '香川県県在住、讃岐うどん、コシが強く、つるっとした喉ごしの良さ、もちもちの食感が楽しめる、麵が主役の讃岐うどん。讃岐うどんのスタンダードな食べ方は、冷たいうどんに好きな量の薬味をかけ、そのまま「だし醤油」をかけるだけの、その名も「しょうゆうどん」です。',
            'user_id' => '3',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('posts')->insert([
            'text' => '神奈川在住、ニュータンタンメン（川崎市）川崎市民のソウルフードとして長年親しまれ、今や市を代表するご当地グルメの仲間入りを果たしたのが「ニュータンタンメン」です！',
            'user_id' => '4',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('posts')->insert([
            'text' => '大阪府在住、1位 たこ焼き道楽 わなか千日前本店',
            'user_id' => '5',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('posts')->insert([
            'text' => '埼玉県在住、武蔵野うどん（入間・比企地域）今では豚肉などを様々な具材をトッピングした汁入りメニューがありますが、基本的なスタイルはざるに盛って「ざるうどん」や「もりうどん」として提供されるのが一般的',
            'user_id' => '6',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('posts')->insert([
            'text' => '群馬県在住、「上州牛」とは、上州銘柄牛の統一ブランド名で、群馬県内で肥育され食肉処理された肉用牛（黒毛和種・交雑種）の総称。その中でも、黒毛和種は「上州和牛」と称します。旅行の際は必ず！！',
            'user_id' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('posts')->insert([
            'text' => '北海道在住、北海道グルメ②【ラーメン】、特に札幌ラーメン！！東京、台湾、香港など、国内外に展開する「えびそば一幻」は、札幌に本店を構えるラーメン店です。',
            'user_id' => '2',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('posts')->insert([
            'text' => '香川県県在住、骨付鳥！！その店オリジナルの味付けを行う骨付鳥の名店がたくさんり、ボリュームたっぷりでディナーには最適、ビールなどのお酒との相性も抜群です。食べた時にこぼれ落ちた肉汁を、付け合せのキャベツに付けていただくのが通の楽しみ方です。',
            'user_id' => '3',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('posts')->insert([
            'text' => '神奈川在住、牛鍋（横浜市）牛鍋もそのひとつで、明治時代の横浜で誕生し、文明開化の象徴として広く食されていた料理です。',
            'user_id' => '4',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('posts')->insert([
            'text' => '大阪府在住、2位 甲賀流 本店',
            'user_id' => '5',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('posts')->insert([
            'text' => '埼玉県在住、豆腐ラーメン（さいたま市岩槻区）',
            'user_id' => '6',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('posts')->insert([
            'text' => '群馬県在住、「焼きまんじゅう」は群馬県民のソウルフード！！外側がカリッと焼き上がり、中はふんわりとした食感。甘味のあるたれが食欲をそそりますよ！！',
            'user_id' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('posts')->insert([
            'text' => '北海道在住、北海道グルメ③【スープカレー】、スープカレーは、さらさらとしたスープ状のカレーにぶつ切りの野菜やお肉が入った料理のこと。北海道の中でも、特に発祥の地である札幌には、多くの専門店があります。',
            'user_id' => '2',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('posts')->insert([
            'text' => '香川県県在住、あんもち雑煮！！あんもち雑煮は、香川県讃岐地方で正月に食べられている郷土料理です。白味噌仕立ての汁にあんもちが入っており、味噌の塩気とあんこの甘味が絶妙にマッチし、クセになる味わい。',
            'user_id' => '3',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('posts')->insert([
            'text' => '神奈川在住、よこすか海軍カレー（横須賀市）そんなネイビーカラーが強い横須賀のご当地グルメといえば、旧帝国海軍由来の「よこすか海軍カレー」です。',
            'user_id' => '4',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('posts')->insert([
            'text' => '大阪府在住、3位 元祖 味穂',
            'user_id' => '5',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('posts')->insert([
            'text' => '埼玉県在住、大宮ナポリタン（さいたま市大宮区）',
            'user_id' => '6',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('posts')->insert([
            'text' => '群馬県在住、「下仁田ネギ」は白根の部分が非常に太いのが特徴的。直径4cmから9cmほどのものも！とろりとした食感と甘さの味わいを楽しむためには、シンプルな「鍋」や「すき焼き」、アルミホイルで巻いてグリルで焼いた「焼きネギ」がおすすめ！！',
            'user_id' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}

