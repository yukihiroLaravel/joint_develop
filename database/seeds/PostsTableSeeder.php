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
            ]);
            DB::table('posts')->insert([
                'content' => '好きなブランドはコブラです',
            ]);
            DB::table('posts')->insert([
                'content' => 'ドライバー飛距離は年々落ちてきました',
            ]);
            DB::table('posts')->insert([
                'content' => '毎日素振りはしてます',
            ]);
            DB::table('posts')->insert([
                'content' => '最高スコアは７５です',
            ]);
    }
}
