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
            'content' => 'テスト文1です',
            'user_id' => 1,  
        ]);
       
        DB::table('posts')->insert([
            'content' => 'テスト文2です',
            'user_id' => 2,
        ]);

        DB::table('posts')->insert([
            'content' => 'テスト文3です',
            'user_id' => 3,
        ]);

        DB::table('posts')->insert([
            'content' => 'テスト文4です',
            'user_id' => 4,
        ]);

        DB::table('posts')->insert([
            'content' => 'テスト文5です',
            'user_id' => 1,
        ]);

        DB::table('posts')->insert([
            'content' => 'テスト文6です',
            'user_id' => 2,  
        ]);
       
        DB::table('posts')->insert([
            'content' => 'テスト文7です',
            'user_id' => 3,
        ]);

        DB::table('posts')->insert([
            'content' => 'テスト文8です',
            'user_id' => 4,
        ]);

        DB::table('posts')->insert([
            'content' => 'テスト文9です',
            'user_id' => 1,
        ]);

        DB::table('posts')->insert([
            'content' => 'テスト文10です',
            'user_id' => 2,
        ]);

        DB::table('posts')->insert([
            'content' => 'テスト文11です',
            'user_id' => 3,
        ]);
    }
}
