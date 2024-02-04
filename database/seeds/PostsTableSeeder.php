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
            'email' => 'test1@yokoi.com',
            'password' => bcrypt('test1')
        ]);
        DB::table('posts')->insert([
            'name' => 'test2',
            'email' => 'test2@yokoi.com',
            'password' => bcrypt('test2')
        ]);
        DB::table('posts')->insert([
            'name' => 'test3',
            'email' => 'test3@yokoi.com',
            'password' => bcrypt('test3')
        ]);
        DB::table('posts')->insert([
            'name' => 'test4',
            'email' => 'test4@yokoi.com',
            'password' => bcrypt('test4')
        ]);
    }
}