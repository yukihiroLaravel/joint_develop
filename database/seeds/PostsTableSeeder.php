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
            'id' => '1',
            'title' => 'ダイエットに効果的なもの',
            'user_id' => '1',
            'content' => '睡眠時間の確保、食事制限、運動習慣の３つです。',
        ]);

        DB::table('posts')->insert([
            'id' => '2',
            'title' => '睡眠時間について',
            'user_id' => '2',
            'content' => '7時間〜8時間の間が効果的。それ以上でもそれ以下でも体には良くない。',
        ]);

        DB::table('posts')->insert([
            'id' => '3',
            'title' => '食事制限について',
            'user_id' => '3',
            'content' => '必要エネルギーよりも摂取しないこと。腹8部までに収めること',
        ]);

        DB::table('posts')->insert([
            'id' => '4',
            'title' => '食事の取り方について',
            'user_id' => '4',
            'content' => 'ペースト状まで咀嚼すること。20分以上かけてゆっくりと食事をすること。',
        ]);
    }
}
