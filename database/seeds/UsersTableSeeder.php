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
        $usersData = [
            ['name' => 'test1', 'email' => 'test1@test1.com', 'password' => bcrypt('test1test1')],
            ['name' => 'test2', 'email' => 'test2@test2.com', 'password' => bcrypt('test2test2')],
            ['name' => 'test3', 'email' => 'test3@test3.com', 'password' => bcrypt('test3test3')],
            ['name' => 'test4', 'email' => 'test4@test4.com', 'password' => bcrypt('test4test4')],
        ];

        foreach ($usersData as $userData) {
            DB::table('users')->insert($userData);
        }
    }
}
