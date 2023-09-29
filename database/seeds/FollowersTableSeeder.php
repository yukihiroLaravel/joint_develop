<?php

use Illuminate\Database\Seeder;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // フォロー関係のテストデータを追加
        DB::table('followers')->insert([
            'follower_id' => 1, // フォロワーのユーザーID
            'user_id' => 2,     // フォローしているユーザーのID
        ]);
    }
}
