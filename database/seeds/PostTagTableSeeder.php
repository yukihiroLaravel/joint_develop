<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\Tag;

class PostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::all();
        // 投稿が1件もなければ何もしない
        if ($tags->isEmpty()) {
            return;
        }

        Post::all()->each(function ($post) use ($tags) {
            // ランダムで1〜3個のタグを付ける
            $tagIds = $tags->random(rand(1, min(3, $tags->count())))->pluck('id')->toArray();
            $post->tags()->syncWithoutDetaching($tagIds);
        });
    }
}
