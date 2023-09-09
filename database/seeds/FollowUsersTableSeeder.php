<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('follow_users')->insert([
            'user_id' => 1,
            'followed_id' => 2,
        ]);
        DB::table('follow_users')->insert([
            'user_id' => 2,
            'followed_id' => 1,
        ]);
        DB::table('follow_users')->insert([
            'user_id' => 1,
            'followed_id' => 3,
        ]);
        DB::table('follow_users')->insert([
            'user_id' => 3,
            'followed_id' => 1,
        ]);
        DB::table('follow_users')->insert([
            'user_id' => 2,
            'followed_id' => 3,
        ]);
        DB::table('follow_users')->insert([
            'user_id' => 3,
            'followed_id' => 2,
        ]);
    }
}
