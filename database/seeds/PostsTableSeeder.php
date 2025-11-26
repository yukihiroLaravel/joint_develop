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
            'user_id'=>1,
            'title'=>'初投稿',
            'body'=>'これはテスト投稿です。',
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
        DB::table('posts')->insert([
            'user_id'=>1,
            'title'=>'phpについて',
            'body'=>'phpはわかりやすいプログラミング言語です。',
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
        DB::table('posts')->insert([
            'user_id'=>1,
            'title'=>'laravelについて',
            'body'=>'laravelはとても便利なフレームワークです。',
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
        DB::table('posts')->insert([
            'user_id'=>1,
            'title'=>'プログラミングについて',
            'body'=>'プログラミングは難しいが楽しい。',
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
    }
}
