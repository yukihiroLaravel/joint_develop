<?php

use Illuminate\Database\Seeder;
use App\Post;

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
            'title' => 'Example Post 1',
            'content' => 'This is the content of the first post.',
            'user_id' => 1,
        ]);

        DB::table('posts')->insert([
            'title' => 'Example Post 2',
            'content' => 'This is the content of the second post.',
            'user_id' => 2,
        ]);

        DB::table('posts')->insert([
            'title' => 'Example Post 3',
            'content' => 'This is the content of the third post.',
            'user_id' => 3,
        ]);

        DB::table('posts')->insert([
            'title' => 'Example Post 4',
            'content' => 'This is the content of the fourth post.',
            'user_id' => 4,
        ]);

        DB::table('posts')->insert([
            'title' => 'Example Post 5',
            'content' => 'This is the content of the fifth post.',
            'user_id' => 1,
        ]);
    }

    
}
