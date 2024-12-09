<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    //  userIDカラムが必要
    public function run()
    {
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' => 'sake'
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'content' => 'soju'
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'content' => 'wine'
        ]);
        DB::table('posts')->insert([
            'user_id' => 4,
            'content' => 'beer'
        ]);
    }
}
