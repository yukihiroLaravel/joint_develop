<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\User;

class FollowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $follows = [
            2 => [3, 4], // ID 2のユーザは ID 3, 4のユーザをフォロー
            3 => [2, 4], // ID 3のユーザは ID 2, 4のユーザをフォロー
            4 => [2],    // ID 4のユーザは ID 2のユーザをフォロー
        ];

        foreach ($follows as $usersId => $followedUsersIds) {
            foreach ($followedUsersIds as $followedUsersId) {
                DB::table('follows')->insert([
                    'user_id' => $usersId,
                    'followed_user_id' => $followedUsersId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
