<?php

use Illuminate\Database\Seeder;
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
        $following_data = [
            ['following_id' => 1, 'followed_id' => 2], // id1はid2をフォローしてる
            ['following_id' => 1, 'followed_id' => 5], // id1はid5をフォローしてる
            ['following_id' => 2, 'followed_id' => 3], // id2はid3をフォローしてる
            ['following_id' => 2, 'followed_id' => 4], // id2はid4をフォローしてる
            ['following_id' => 3, 'followed_id' => 2], // id3はid2をフォローしてる
        ];

        foreach($following_data as $following_values) {

            $following_user = User::find($following_values['following_id']);
            $followed_user = User::find($following_values['followed_id']);
            $following_user->follow($followed_user->id);
        }
    }
}
