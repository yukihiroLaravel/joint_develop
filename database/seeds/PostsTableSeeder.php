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
            'content,140' => 'テスト1',

        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'content,140' => 'テスト2',
            
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'content,140' => 'テスト3',
            
        ]);
        DB::table('posts')->insert([
            'user_id' => 4,
            'content,140' => 'テスト4',
            
        ]);
        DB::table('posts')->insert([
            'user_id' => 5,
            'content,140' => 'テスト5',
            
        ]);
        DB::table('posts')->insert([
            'user_id' => 6,
            'content,140' => 'テスト6',
            
        ]);
        DB::table('posts')->insert([
            'user_id' => 7,
            'content,140' => 'テスト7',
            
        ]);
        DB::table('posts')->insert([
            'user_id' => 8,
            'content,140' => 'テスト8',
            
        ]);
        DB::table('posts')->insert([
            'user_id' => 9,
            'content,140' => 'テスト9',
            
        ]);
        DB::table('posts')->insert([
            'user_id' => 10,
            'content,140' => 'テスト10',
            
        ]);
        DB::table('posts')->insert([
            'user_id' => 11,
            'content,140' => 'テスト11',
            
        ]);
    }
}
