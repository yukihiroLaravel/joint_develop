<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // フォロー関係のテストデータを追加
        DB::table('follows')->insert([
            'follow_id' => 1, // フォロワーのユーザーID
            'user_id' => 2,     // フォローしているユーザーのID
        ]);
    }
}