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
            'content' => '大会初日の結果',
        ]);

        DB::table('posts')->insert([
            'user_id' => '1',
            'content' => '大会2日目の結果',
        ]);

        DB::table('posts')->insert([
            'user_id' => '1',
            'content' => '大会3日目の結果',
        ]);

        DB::table('posts')->insert([
            'user_id' => '2',
            'content' => '大会4日目の結果',
        ]);

        DB::table('posts')->insert([
            'user_id' => '2',
            'content' => '大会5日目の結果',
        ]);

        DB::table('posts')->insert([
            'user_id' => '2',
            'content' => '大会6日目の結果',
        ]);

        DB::table('posts')->insert([
            'user_id' => '3',
            'content' => '大会7日目の結果',
        ]);

        DB::table('posts')->insert([
            'user_id' => '3',
            'content' => '大会8日目の結果',
        ]);

        DB::table('posts')->insert([
            'user_id' => '3',
            'content' => '大会9日目の結果',
        ]);

        DB::table('posts')->insert([
            'user_id' => '4',
            'content' => '大会10日目の結果',
        ]);

        DB::table('posts')->insert([
            'user_id' => '4',
            'content' => '大会11日目の結果',
        ]);
    }
}
