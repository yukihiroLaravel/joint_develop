<?php
use Illuminate\Database\Seeder;
class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'content' => 'テスト投稿です。',
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'content' => 'テストの投稿です。',
            'user_id' => 2,
        ]);
        DB::table('posts')->insert([
            'content' => 'テスト投稿です。',
            'user_id' => 3,
        ]);
        DB::table('posts')->insert([
            'content' => 'テストの投稿です。',
            'user_id' => 4,
        ]);
        DB::table('posts')->insert([
            'content' => 'テスト投稿です。',
            'user_id' => 5,
        ]);
    }
}