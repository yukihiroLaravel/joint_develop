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
        //
        DB::table('posts')->insert([
            'user_id' =>1,
            'content' => 'これはテスト投稿です。1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('posts')->insert([
            'user_id' =>2,
            'content' => 'これはテスト投稿です。2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('posts')->insert([
            'user_id' =>3,
            'content' => 'これはテスト投稿です。3',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('posts')->insert([
            'user_id' =>4,
            'content' => 'これはテスト投稿です。4',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('posts')->insert([
            'user_id' =>5,
            'content' => 'これはテスト投稿です。5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('posts')->insert([
            'user_id' =>6,
            'content' => 'これはテスト投稿です。6',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('posts')->insert([
            'user_id' =>7,
            'content' => 'これはテスト投稿です。7',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('posts')->insert([
            'user_id' =>8,
            'content' => 'これはテスト投稿です。8',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('posts')->insert([
            'user_id' =>9,
            'content' => 'これはテスト投稿です。9',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('posts')->insert([
            'user_id' =>10,
            'content' => 'これはテスト投稿です。10',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('posts')->insert([
            'user_id' =>11,
            'content' => 'これはテスト投稿です。11',
            'created_at' => now(),
            'updated_at' => now(),
        ]);




    }
}
