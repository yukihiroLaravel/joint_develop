<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()       // php artisan db:seed実行したときにここの中を呼び出す
    {
        $this->call(UsersTableSeeder::class);
        $this->call(PostsTableSeeder::class);
    }
}