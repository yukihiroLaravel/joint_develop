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
            'title' => 'test1',
            'content' => 'testcontent',
           
        ]);
        DB::table('posts')->insert([
            'title' => 'テストタイトル',
            'content' => '投稿した文',
           
        ]);
    }
}
