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
        for ($i = 1; $i < 5; $i++) {
            for ($postcount = 1; $postcount < 4; $postcount++) {
                DB::table('posts')->insert([
                    'user_id' => $i,
                    'content' => "testpost_テスト投稿{$i}-{$postcount}",
                    'created_at' => now()->subDays(rand(1, 30)), // ランダムで過去1〜30日
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
