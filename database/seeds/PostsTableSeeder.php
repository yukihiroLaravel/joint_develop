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
        for ($num = 1; $num < 6; $num++){
            DB::table('posts')->insert([
                'user_id' => $num,
                'content' => 'test'.$num,
                'youtube_id' => 'youtube_id'.$num,
            ]);
        }
    }
}
