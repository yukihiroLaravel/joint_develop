<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class); //追記
        $this->call(PostsTableSeeder::class); //追記
        $this->call(FollowUsersTableSeeder::class);
    }
}