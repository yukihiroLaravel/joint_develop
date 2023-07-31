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
            'user_id' => user1@user.com,
            'password' => bcrypt('test1')
        ]);
        DB::table('posts')->insert([
            'text' => 'test2',
            'user_id' => user2@user.com,
            'password' => bcrypt('test2')
        ]);
        DB::table('posts')->insert([
            'text' => 'test3',
            'user_id' => user3@user.com,
            'password' => bcrypt('test3')
        ]);
        DB::table('posts')->insert([
            'text' => 'test4',
            'user_id' => user4@user.com,
            'password' => bcrypt('test4')
        ]);
    }
}
