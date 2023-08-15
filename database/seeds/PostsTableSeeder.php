<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('posts')->insert([
                'content' => '好きなブランドはコブラです',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('posts')->insert([
                'content' => 'ドライバー飛距離は年々落ちてきました',
                'user_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('posts')->insert([
                'content' => '毎日素振りはしてます',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('posts')->insert([
                'content' => '最高スコアは７５です',
                'user_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('posts')->insert([
                'content' => 'ゴルフクラブが恋人です',
                'user_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('posts')->insert([
                'content' => '好きなブランドはコブラです',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('posts')->insert([
                'content' => 'ドライバー飛距離は年々落ちてきました',
                'user_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('posts')->insert([
                'content' => '毎日素振りはしてます',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('posts')->insert([
                'content' => '最高スコアは７５です',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('posts')->insert([
                'content' => 'ゴルフクラブが恋人です',
                'user_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('posts')->insert([
                'content' => '好きなブランドはコブラです',
                'user_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('posts')->insert([
                'content' => 'ドライバー飛距離は年々落ちてきました',
                'user_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('posts')->insert([
                'content' => '毎日素振りはしてます',
                'user_id' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('posts')->insert([
                'content' => '最高スコアは７５です',
                'user_id' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }
}
