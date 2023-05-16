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
       'user_id' => '1', 
       'user_name'=> 'test1',
       'comment_content' => 'テスト１',
      ]);
      DB::table('posts')->insert([
       'user_id' => '2',
       'user_name' => 'test2',
       'comment_content' => 'テスト２',
      ]);
      DB::table('posts')->insert([
        'user_id' => '3',
        'user_name' => 'test3',
        'comment_content' => 'テスト３',
      ]);
    }
}
