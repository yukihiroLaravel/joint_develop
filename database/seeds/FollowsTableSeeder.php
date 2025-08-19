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
        $manualFollows = [
            2 => [3, 4], // ID 2のユーザは ID 3, 4のユーザをフォロー
            3 => [2, 4], // ID 3のユーザは ID 2, 4のユーザをフォロー
            4 => [2],    // ID 4のユーザは ID 2のユーザをフォロー
        ];

        $alreadyFollowed = []; // 重複を避けるための記録用

        foreach ($manualFollows as $userId => $followedIds) {
            foreach ($followedIds as $followedId) {
                DB::table('follows')->insert([
                    'user_id' => $userId,
                    'followed_user_id' => $followedId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $alreadyFollowed["{$userId}-{$followedId}"] = true;
            }
        }

        // ユーザー数を取得（例：1～30）
        $userIds = range(1, 30);

        foreach ($userIds as $followerId) {
            $followCandidates = array_diff($userIds, [$followerId]);
            shuffle($followCandidates);
            $follows = array_slice($followCandidates, 0, 10);

            foreach ($follows as $followedId) {
                $key = "{$followerId}-{$followedId}";
                if (!isset($alreadyFollowed[$key])) {
                    DB::table('follows')->insert([
                        'user_id' => $followerId,
                        'followed_user_id' => $followedId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $alreadyFollowed[$key] = true;
                }
            }
        }
    }
}