<?php

use Illuminate\Database\Seeder;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('followers')->insert([
            'following_user_id' => 5,
            'followed_user_id' => 1
        ]);
        DB::table('followers')->insert([
            'following_user_id' => 1,
            'followed_user_id' => 5,
        ]);
        DB::table('followers')->insert([
            'following_user_id' => 5,
            'followed_user_id' => 3
        ]);
        DB::table('followers')->insert([
            'following_user_id' => 1,
            'followed_user_id' => 4
        ]);
        DB::table('followers')->insert([
            'following_user_id' => 2,
            'followed_user_id' => 1
        ]);
        DB::table('followers')->insert([
            'following_user_id' => 5,
            'followed_user_id' => 2
        ]);
        DB::table('followers')->insert([
            'following_user_id' => 2,
            'followed_user_id' => 3
        ]);
    }
}
