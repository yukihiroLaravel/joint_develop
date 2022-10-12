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
            'text' => 'aaaaaaa',
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'text' => 'ssssss',
            'user_id' => 2,
        ]);
        DB::table('posts')->insert([
            'text' => 'zzzzzzz',
            'user_id' => 3,
        ]);
        DB::table('posts')->insert([
            'text' => 'xxxxxxxxx',
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'text' => 'ああああああああ',
            'user_id' => 2,
        ]);
        DB::table('posts')->insert([
            'text' => 'ええええええええ',
            'user_id' => 3,
        ]);
        DB::table('posts')->insert([
            'text' => 'いいいいいいいいいいい',
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'text' => 'うううううううう',
            'user_id' => 2,
        ]);
        DB::table('posts')->insert([
            'text' => 'おおおおおおおお',
            'user_id' => 3,
        ]);
        DB::table('posts')->insert([
            'text' => 'kkkkkkkkk',
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'text' => 'llllllllll',
            'user_id' => 2,
        ]);
        DB::table('posts')->insert([
            'text' => 'hhhhhhhhh',
            'user_id' => 3,
        ]);

    }
}