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
            'user_id' => 1,
            'content' => 'テスト4',    
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'content' => 'テスト5',           
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'content' => 'テスト6',    
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' => 'テスト7',   
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'content' => 'テスト8',  
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'content' => 'テスト9',   
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' => 'テスト10', 
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'content' => 'テスト11',
        ]);
    }
}
