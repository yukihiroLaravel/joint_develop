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
        $this->call(UsersTableSeeder::class); //コメントアウトを外す事でUsersTableSeederが実行される
        $this->call(PostsTableSeeder::class);
        $this->call(FollowsTableSeeder::class);
    }
}
