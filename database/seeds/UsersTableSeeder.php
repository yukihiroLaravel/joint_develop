<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'user1',
            'email' => 'user1@test.com',
            'password' => bcrypt('password')
        ]);
        DB::table('users')->insert([
            'name' => 'user2',
            'email' => 'user2@test.com',
            'password' => bcrypt('password')
        ]);
        DB::table('users')->insert([
            'name' => 'user3',
            'email' => 'user3@test.com',
            'password' => bcrypt('password')
        ]);
        DB::table('users')->insert([
            'name' => 'user4',
            'email' => 'user4@test.com',
            'password' => bcrypt('password')
        ]);
        DB::table('users')->insert([
            'name' => 'user5',
            'email' => 'user5@test.com',
            'password' => bcrypt('password')
        ]);
    }
}
