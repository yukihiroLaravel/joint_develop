<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'id' => 1,
            'user_id' => 1,
            'content' => 'あああああ'
        ]);
        DB::table('posts')->insert([
            'id' => 2,
            'user_id' => 1,
            'content' => 'いいいい'
        ]);
        DB::table('posts')->insert([
            'id' => 3,
            'user_id' => 2,
            'content' => 'うううう'
        ]);
        DB::table('posts')->insert([
            'id' => 4,
            'user_id' => 3,
            'content' => 'ええええ'
        ]);
        DB::table('posts')->insert([
            'id' => 5,
            'user_id' => 4,
            'content' => 'おおおおお'
        ]);
        DB::table('posts')->insert([
            'id' => 6,
            'user_id' => 5,
            'content' => 'かかかか'
        ]);
        DB::table('posts')->insert([
            'id' => 7,
            'user_id' => 6,
            'content' => 'きききき'
        ]);
        DB::table('posts')->insert([
            'id' => 8,
            'user_id' => 7,
            'content' => 'くくくく'
        ]);
        DB::table('posts')->insert([
            'id' => 9,
            'user_id' => 8,
            'content' => 'けけけけ'
        ]);
        DB::table('posts')->insert([
            'id' => 10,
            'user_id' => 9,
            'content' => 'ここここ'
        ]);
        DB::table('posts')->insert([
            'id' => 11,
            'user_id' => 10,
            'content' => 'ささささ'
        ]);
    }
}
