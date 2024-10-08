<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Post;
use Faker\Factory as Faker;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('ja_JP'); // 日本語のFakerインスタンスを作成

        $users = User::all();

        foreach ($users as $user) {
            Post::create([
                'user_id' => $user->id,
                'post' => $faker->realText(50, 5), // ランダムな日本語テキストを生成
                'is_published' => true,
            ]);
        }
    }
}