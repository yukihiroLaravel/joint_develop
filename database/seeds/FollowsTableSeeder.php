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
            ['following_id' => 2, 'followed_id' => 8], // 2-8フォローしてる
            ['following_id' => 3, 'followed_id' => 4], // 3-4フォローしてる
            ['following_id' => 3, 'followed_id' => 5], // 3-5フォローしてる
            ['following_id' => 4, 'followed_id' => 3], // 4-3フォローしてる
            ['following_id' => 10, 'followed_id' => 1], // 10-1フォローしてる
        ];

        foreach($following_data as $following_values) {

            $following_user = User::find($following_values['following_id']);
            $followed_user = User::find($following_values['followed_id']);
            $following_user->follow($followed_user->id);
        }
    }
}
