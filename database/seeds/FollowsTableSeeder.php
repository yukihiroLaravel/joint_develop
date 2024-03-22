<?php

use App\User;
use Illuminate\Database\Seeder;

class FollowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 15; $i++) {
            $arrayUsersId = range(1, 15);
            $index = $i - 1;
            unset($arrayUsersId[$index]);
            $followedUsersIndex = array_rand($arrayUsersId, 5);
            $followUser = User::find($i);
            foreach ($followedUsersIndex as $followedUserIndex) {
                $followUser->followUsers()->attach($arrayUsersId[$followedUserIndex]);
            }
        }
    }
}
