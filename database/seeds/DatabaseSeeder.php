<?php

use Illuminate\Database\Seeder;
use App\PostsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            PostsTableSeeder::class,
            FollowsTableSeeder::class,            
        ]);
    }
}
