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
            'user_id' => 1,
            'content' => '　Twitterの制限である最大140文字を超えてツイートするための新しい手法が見つかり、その発想の斬新さが一部で話題になっている。',
        ]);
        for ($i = 2; $i <= 4; $i++) {
            DB::table('posts')->insert([
                'user_id' => $i,
                'content' => 'テストです。',
            ]);
        }
    }
}
