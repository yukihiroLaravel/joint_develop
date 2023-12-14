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
        for($i = 1; $i <= 200; $i++){
            DB::table('posts')->insert([
                'content' => 'これは' .$i .'個目の投稿です。',
                'user_id' => rand(1, 5),
            ]);
        }
    }
}
