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
            'content' => 'test1',
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'content' => 'test2',
            'user_id' => 2,
        ]);
        DB::table('posts')->insert([
            'content' => 'test3',
            'user_id' => 3,
        ]);
        DB::table('posts')->insert([
            'content' => 'test4',
            'user_id' => 4,
        ]);
        DB::table('posts')->insert([
            'content' => 'test5',
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'content' => 'test6',
            'user_id' => 2,
        ]);
        DB::table('posts')->insert([
            'content' => 'test7',
            'user_id' => 3,
        ]);
        DB::table('posts')->insert([
            'content' => 'test8',
            'user_id' => 4,
        ]);
        DB::table('posts')->insert([
            'content' => 'test9',
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'content' => 'test10',
            'user_id' => 2,
        ]);
        DB::table('posts')->insert([
            'content' => 'test11',
            'user_id' => 3,
        ]);
    }
}
