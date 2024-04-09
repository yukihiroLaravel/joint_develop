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
        $posts = [
            '初期ポスト1',
            '初期ポスト2',
            '初期ポスト3'
        ];

        foreach ($posts as $post) {
            DB::table('posts')->insert([
                'user_id' => 1,
                'content' => $post,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
