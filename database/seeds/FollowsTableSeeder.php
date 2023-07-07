<?php

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
        DB::table('follows')->insert([
            'user_id' => '1',
            'followed_user_id' => '2',
        ]);
        DB::table('follows')->insert([
            'user_id' => '1',
            'followed_user_id' => '3',
        ]);
        DB::table('follows')->insert([
            'user_id' => '1',
            'followed_user_id' => '4',
        ]);
        DB::table('follows')->insert([
            'user_id' => '2',
            'followed_user_id' => '1',
        ]);
        DB::table('follows')->insert([
            'user_id' => '2',
            'followed_user_id' => '3',
        ]);
        DB::table('follows')->insert([
            'user_id' => '2',
            'followed_user_id' => '4',
        ]);
        DB::table('follows')->insert([
            'user_id' => '3',
            'followed_user_id' => '1',
        ]);
        DB::table('follows')->insert([
            'user_id' => '3',
            'followed_user_id' => '2',
        ]);
        DB::table('follows')->insert([
            'user_id' => '3',
            'followed_user_id' => '4',
        ]);
        DB::table('follows')->insert([
            'user_id' => '4',
            'followed_user_id' => '1',
        ]);
        DB::table('follows')->insert([
            'user_id' => '4',
            'followed_user_id' => '2',
        ]);
        DB::table('follows')->insert([
            'user_id' => '4',
            'followed_user_id' => '3',
        ]);
    }
}
