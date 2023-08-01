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
            'text' => 'test1',
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'text' => 'test2',
            'user_id' => 2,
        ]);
        DB::table('posts')->insert([
            'text' => 'test3',
            'user_id' => 3,
        ]);
        DB::table('posts')->insert([
            'text' => 'test4',
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'text' => 'test5',
            'user_id' => 2,
        ]);
        DB::table('posts')->insert([
            'text' => 'test6',
            'user_id' => 3,
        ]);
        DB::table('posts')->insert([
            'text' => 'test7',
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'text' => 'test8',
            'user_id' => 2,
        ]);
        DB::table('posts')->insert([
            'text' => 'test9',
            'user_id' => 3,
        ]);
        DB::table('posts')->insert([
            'text' => 'test10',
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'text' => 'test11',
            'user_id' => 2,
        ]);
    }
}
