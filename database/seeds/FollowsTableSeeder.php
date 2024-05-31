<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\DB;

class FollowsTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $userIds = $users->pluck('id')->toArray();

        foreach ($users as $user) {
            // 自分を除いたユーザIDの配列を作成
            $otherUserIds = array_diff($userIds, [$user->id]);

            // その配列からランダムに30人のユーザIDを選択
            $selectedUserIds = array_rand(array_flip($otherUserIds), 30);

            // 選択したユーザIDに対してフォロー関係を設定
            foreach ($selectedUserIds as $followId) {
                DB::table('follows')->insert([
                    'follower_id' => $user->id,
                    'followed_id' => $followId
                ]);
            }
        }
    }
}
