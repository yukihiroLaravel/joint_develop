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
                'content' => 'ゴルフクラブが恋人です',
                'user_id' => 1,
            ]);
            DB::table('posts')->insert([
                'content' => '好きなブランドはコブラです',
                'user_id' => 2,
            ]);
            DB::table('posts')->insert([
                'content' => 'ドライバー飛距離は年々落ちてきました',
                'user_id' => 3,
            ]);
            DB::table('posts')->insert([
                'content' => '毎日素振りはしてます',
                'user_id' => 4,
            ]);
            DB::table('posts')->insert([
                'content' => '最高スコアは７５です',
                'user_id' => 5,
            ]);
    }
}
