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
            'content' => '　今までに行ったことのあるオススメのお店や美味しかった料理・気になっている食べ物について語ろう。',
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' =>"おでんが好きです。"
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' =>""
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' =>""
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' =>""
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' =>""
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' =>""
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' =>""
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' =>""
        ]);
        }
    }

