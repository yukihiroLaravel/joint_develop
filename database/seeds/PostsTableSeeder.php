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




    }
}
