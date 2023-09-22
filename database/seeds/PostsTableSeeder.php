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
            'content' => 'abc',
            'user_id' => 1
        ]);
        DB::table('posts')->insert([
            'content' => 'def',
            'user_id' => 2
        ]);
    }
}
