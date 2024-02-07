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
            'text' => 'お茶',
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'text' => 'コーヒー',
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'text' => '牛乳',
        ]);
        DB::table('posts')->insert([
            'user_id' => 4,
            'text' => '水',
        ]);
    }
}
