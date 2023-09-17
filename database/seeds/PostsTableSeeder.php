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
            'user_id' => 1,
            'content' => 'テスト1',

        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'content' => 'テスト2',
            
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'content' => 'テスト3',
            
        ]);
        DB::table('posts')->insert([
            'user_id' => 4,
            'content' => 'テスト4',
            
        ]);
        DB::table('posts')->insert([
            'user_id' => 5,
            'content' => 'テスト5',
            
        ]);
        DB::table('posts')->insert([
            'user_id' => 6,
            'content' => 'テスト6',
            
        ]);
        DB::table('posts')->insert([
            'user_id' => 7,
            'content' => 'テスト7',
            
        ]);
        DB::table('posts')->insert([
            'user_id' => 8,
            'content' => 'テスト8',
            
        ]);
        DB::table('posts')->insert([
            'user_id' => 9,
            'content' => 'テスト9',
            
        ]);
        DB::table('posts')->insert([
            'user_id' => 10,
            'content' => 'テスト10',
            
        ]);
        DB::table('posts')->insert([
            'user_id' => 11,
            'content' => 'テスト11',
            
        ]);
    }
}
