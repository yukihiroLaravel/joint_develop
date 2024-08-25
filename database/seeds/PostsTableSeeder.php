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
            'name' => 'test1',
            'contents' => '大会初日の結果',
        ]);

        DB::table('posts')->insert([
            'user_id' => '1',
            'name' => 'test1',
            'contents' => '大会2日目の結果',
        ]);

        DB::table('posts')->insert([
            'user_id' => '1',
            'name' => 'test1',
            'contents' => '大会3日目の結果',
        ]);

        DB::table('posts')->insert([
            'user_id' => '2',
            'name' => 'test2',
            'contents' => '大会4日目の結果',
        ]);

        DB::table('posts')->insert([
            'user_id' => '2',
            'name' => 'test2',
            'contents' => '大会5日目の結果',
        ]);

        DB::table('posts')->insert([
            'user_id' => '2',
            'name' => 'test2',
            'contents' => '大会6日目の結果',
        ]);

        DB::table('posts')->insert([
            'user_id' => '3',
            'name' => 'test3',
            'contents' => '大会7日目の結果',
        ]);

        DB::table('posts')->insert([
            'user_id' => '3',
            'name' => 'test3',
            'contents' => '大会8日目の結果',
        ]);

        DB::table('posts')->insert([
            'user_id' => '3',
            'name' => 'test3',
            'contents' => '大会9日目の結果',
        ]);

        DB::table('posts')->insert([
            'user_id' => '4',
            'name' => 'test4',
            'contents' => '大会10日目の結果',
        ]);

        DB::table('posts')->insert([
            'user_id' => '4',
            'name' => 'test4',
            'contents' => '大会11日目の結果',
        ]);
    }
}
