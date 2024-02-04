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
            'name' => 'test1',
            'content' => 'Yokoi@test1.',
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'name' => 'test2',
            'content' => 'Yokoi@test2.',
            'user_id' => 2,
        ]);
        DB::table('posts')->insert([
            'name' => 'test3',
            'content' => 'Yokoi@test3.',
            'user_id' => 3,
        ]);
        DB::table('posts')->insert([
            'name' => 'test4',
            'content' => 'Yokoi@test4.',
            'user_id' => 4,
        ]);
    }
}