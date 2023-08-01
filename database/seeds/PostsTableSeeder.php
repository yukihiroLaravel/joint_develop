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
            'text' => 'test18',
            'user_id' => '18',
        ]);
        DB::table('posts')->insert([
            'text' => 'test19',
            'user_id' => '19',
        ]);
        DB::table('posts')->insert([
            'text' => 'test20',
            'user_id' => '20',
        ]);
        DB::table('posts')->insert([
            'text' => 'test21',
            'user_id' => '21',
        ]);
        DB::table('posts')->insert([
            'text' => 'test22',
            'user_id' => '22',
        ]);
        DB::table('posts')->insert([
            'text' => 'test23',
            'user_id' => '23',
        ]);
        DB::table('posts')->insert([
            'text' => 'test24',
            'user_id' => '24',
        ]);
        DB::table('posts')->insert([
            'text' => 'test25',
            'user_id' => '25',
        ]);
        DB::table('posts')->insert([
            'text' => 'test26',
            'user_id' => '26',
        ]);
        DB::table('posts')->insert([
            'text' => 'test27',
            'user_id' => '27',
        ]);
        DB::table('posts')->insert([
            'text' => 'test28',
            'user_id' => '28',
        ]);
        DB::table('posts')->insert([
            'text' => 'test29',
            'user_id' => '29',
        ]);
    }
}
