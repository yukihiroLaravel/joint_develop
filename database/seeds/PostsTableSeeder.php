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
            'text' => 'エンゼルスはあなたがいないと優勝できないです！',
            'user_id' => '1',
            'created_at' => now()
        ]);
        DB::table('posts')->insert([
            'text' => 'あなたはもうベーブルースを超えました！',
            'user_id' => '2',
            'created_at' => now()
        ]);
        DB::table('posts')->insert([
            'text' => '今年もオールスター選ばれて活躍期待しています。',
            'user_id' => '3',
            'created_at' => now()
        ]);
        DB::table('posts')->insert([
            'text' => '目指せワールドシリーズ制覇！',
            'user_id' => '1',
            'created_at' => now()
        ]);
        DB::table('posts')->insert([
            'text' => '今シーズンも目指せMVP！',
            'user_id' => '2',
            'created_at' => now()
        ]);
        DB::table('posts')->insert([
            'text' => '今シーズンもどんな記録作るか楽しみです！',
            'user_id' => '3',
            'created_at' => now()
        ]);
        DB::table('posts')->insert([
            'text' => 'WBCお疲れ様でした。あなたは若い選手の模範です。',
            'user_id' => '1',
            'created_at' => now()
        ]);
        DB::table('posts')->insert([
            'text' => '今シーズンも怪我なく頑張ってください！今年は目指せホームラン王！',
            'user_id' => '2',
            'created_at' => now()
        ]);
        DB::table('posts')->insert([
            'text' => '今シーズンは得意のスイーパーとストレートで目指せサイヤング賞！',
            'user_id' => '3',
            'created_at' => now()
        ]);
        DB::table('posts')->insert([
            'text' => '大谷選手の目標達成シートは一流のエンジニアになるために役に立ちます。自分も書いてこれからのことを考えていきたい',
            'user_id' => '1',
            'created_at' => now()
        ]);
        DB::table('posts')->insert([
            'text' => '大谷選手の試合に向けた準備が素晴らしい。睡眠や食事管理を徹底していてプロ意識が高い。自分も仕事に向けた準備は普段から心がけたい',
            'user_id' => '2',
            'created_at' => now()
        ]);
        DB::table('posts')->insert([
            'text' => '「憧れるのは辞めましょう！」は心に響きました。自分より仕事ができるエンジニアがいたら憧れるのではなくどうすれば自分も仕事ができるエンジニアになれるか考えていかなければいけませんね',
            'user_id' => '3',
            'created_at' => now()
        ]);
        DB::table('posts')->insert([
            'text' => '大谷選手は「使える時間は全部、野球に使っているという自負がある」と話すほどストイック。仕事で成果を出すにはこれくらいの努力が必要ですね',
            'user_id' => '1',
            'created_at' => now()
        ]);
        DB::table('posts')->insert([
            'text' => 'あなたは理想の上司ランキングがスポーツ界1位です。自分も彼のようになって仲間から信頼される人間になりたい',
            'user_id' => '2',
            'created_at' => now()
        ]);
        DB::table('posts')->insert([
            'text' => '天狗にならず謙虚でマナーが素晴らしい。結果を出しても謙虚な人でいたい',
            'user_id' => '3',
            'created_at' => now()
        ]);
    }
}
