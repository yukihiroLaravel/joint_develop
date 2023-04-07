<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 15; $i++) {
            Post::create([
                'user_id' => mt_rand(1, 5),
                'text' => 'テスト投稿です'. $i,
            ]);
        }
    }
}

