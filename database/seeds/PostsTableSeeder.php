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
            'user_id' => '1',
            'content' => '睡眠時間の確保、食事制限、運動習慣の３つです。',
        ]);
        DB::table('posts')->insert([
            'user_id' => '2',
            'content' => '睡眠は7時間〜8時間の間が効果的。それ以上でもそれ以下でも体には良くない。',
        ]);
        DB::table('posts')->insert([
            'user_id' => '3',
            'content' => '必要エネルギーよりも摂取しないこと。腹8部までに収めること',
        ]);
        DB::table('posts')->insert([
            'user_id' => '4',
            'content' => 'ペースト状まで咀嚼すること。咀嚼中は箸を置くこと',
        ]);
        DB::table('posts')->insert([
            'user_id' => '1',
            'content' => '20分以上かけてゆっくりと食事をすること',
        ]);
        DB::table('posts')->insert([
            'user_id' => '2',
            'content' => '食事の優先順位は食物繊維、スープ、タンパク質、炭水化物',
        ]);
        DB::table('posts')->insert([
            'user_id' => '3',
            'content' => '食事中はあまり水分を取らない方がいい',
        ]);
        DB::table('posts')->insert([
            'user_id' => '4',
            'content' => '食前と食後に緑茶を飲むと血糖値が上がりづらい',
        ]);
        DB::table('posts')->insert([
            'user_id' => '1',
            'content' => '間食におすすめなのはナッツ類',
        ]);
        DB::table('posts')->insert([
            'user_id' => '2',
            'content' => '食後の眠気対策として、食後15分以内に10分程度歩くと血糖値が上がりづらく眠くなりにくい',
        ]);
        DB::table('posts')->insert([
            'user_id' => '3',
            'content' => '食事でおすすめは「まごわやさしい」の食材',
        ]);
        DB::table('posts')->insert([
            'user_id' => '3',
            'content' => 'ま＝豆類、ご＝ごま、わ＝わかめ、や＝野菜、さ＝魚、し＝しいたけ、い＝芋類',
        ]);
    }
}
