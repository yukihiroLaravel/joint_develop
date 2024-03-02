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
        $followUsers = [
            [
                'following_id' => 1,
                'followed_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'following_id' => 1,
                'followed_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'following_id' => 1,
                'followed_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'following_id' => 2,
                'followed_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('follow_users')->insert($followUsers);
    }
}