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
        $numFollowing = 10;

        $numFollowed = 5;

        for ($i = 1; $i <= $numFollowing; $i++) {
            $followingId = $i;
            $followedIds = $this->getRandomFollowedIds($i, $numFollowed);

            foreach ($followedIds as $followedId) {
                DB::table('follow_users')->insert([
                    'following_id' => $followingId,
                    'followed_id' => $followedId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function getRandomFollowedIds($currentUserId, $numFollowed)
    {
        $followedIds = range(1, $numFollowed);
        shuffle($followedIds);

        $followedIds = array_diff($followedIds, [$currentUserId]);

        return array_slice($followedIds, 0, rand(1, $numFollowed));
    }
}