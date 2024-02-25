<?php

use Illuminate\Database\Seeder;

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
            'following_id' => 1,
            'followed_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
