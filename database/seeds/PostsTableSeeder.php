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
            'content' => '楽天イーグルスは夏に強い',
            'user_id' => 1,  
        ]);
        
        DB::table('posts')->insert([
            'content' => 'ソフトバンク',
            'user_id' => 2,
        ]);
        
        DB::table('posts')->insert([
            'content' => '広島カープ',
            'user_id' => 3,
        ]);
        
        DB::table('posts')->insert([
            'content' => 'カープ好き',
            'user_id' => 4,
        ]);
        
        DB::table('posts')->insert([
            'content' => 'ソフトバンクの財力',
            'user_id' => 5,
        ]);
        
        DB::table('posts')->insert([
            'content' => '楽天イーグルス',
            'user_id' => 1,
        ]);
        
        DB::table('posts')->insert([
            'content' => 'ソフトバンク',
            'user_id' => 2,
        ]);
        
        DB::table('posts')->insert([
            'content' => '広島カープ',
            'user_id' => 3,
        ]);
        
        DB::table('posts')->insert([
            'content' => '広島カープ',
            'user_id' => 4,
        ]);
        
        DB::table('posts')->insert([
            'content' => 'ソフトバンク',
            'user_id' => 5,
        ]);
        
        DB::table('posts')->insert([
            'content' => '楽天イーグルス',
            'user_id' => 1,
        ]);
    }
}
