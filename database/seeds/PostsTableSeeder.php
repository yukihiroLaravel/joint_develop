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
        for ($i = 1; $i < 12; $i++) {
            DB::table('posts')->insert([
                'content' => 'コメント'.$i.'番目です！',
                'user_id' => rand(1, 3),
            ]);
        }
    }
}
