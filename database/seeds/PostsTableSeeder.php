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
            'content' => 'テストです1',
            'user_id' => '1',
        ]);
        DB::table('posts')->insert([
            'content' => 'テストです2',
            'user_id' => '2',
        ]);
        DB::table('posts')->insert([
            'content' => 'テストです3',
            'user_id' => '3',
        ]);
        DB::table('posts')->insert([
            'content' => 'テストです4',
            'user_id' => '4',
        ]);
    }
}
