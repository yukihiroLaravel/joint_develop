<?php

use Illuminate\Database\Seeder;

class FollowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        for ($i = 1; $i < 98; $i++)
        {
        DB::table('follows')->insert([
            'following_user_id' => 2,
            'followed_user_id' => $i,
        ]);
    }
 }
}