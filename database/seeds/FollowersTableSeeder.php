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
            'following_user_id' => 1,
            'followed_user_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('followers')->insert([
            'following_user_id' => 1,
            'followed_user_id' => 3,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('followers')->insert([
            'following_user_id' => 1,
            'followed_user_id' => 4,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('followers')->insert([
            'following_user_id' => 2,
            'followed_user_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('followers')->insert([
            'following_user_id' => 3,
            'followed_user_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('followers')->insert([
            'following_user_id' => 4,
            'followed_user_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
