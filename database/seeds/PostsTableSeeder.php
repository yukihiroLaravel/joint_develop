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
            'post_title' => "テスト１",
            'area' => '北海道',
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'content' => 'テスト2',
            'post_title' => "テスト2",
            'area' => '関東',
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'content' => 'テスト3',
            'post_title' => "テスト3",
            'area' => '北海道',
        ]);
        DB::table('posts')->insert([
            'user_id' => 4,
            'content' => 'テスト4',
            'post_title' => "テスト4",
            'area' => '九州・沖縄',
        ]);


 }
}
