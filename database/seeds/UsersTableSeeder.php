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
            'name' => 'test1',
            'email' => 'test1@test.com',
            'password' => bcrypt('test1'),
            'avatar' => 'sample_user1.jpg',
        ]);
        DB::table('users')->insert([
            'name' => 'test2',
            'email' => 'test2@test.com',
            'password' => bcrypt('test2'),
            'avatar' => 'sample_user2.jpg',

        ]);
        DB::table('users')->insert([
            'name' => 'test3',
            'email' => 'test3@sample.com',
            'password' => bcrypt('test3'),
            'avatar' => 'sample_user3.jpg',
        ]);
        DB::table('users')->insert([
            'name' => 'test4',
            'email' => 'test4@test.com',
            'password' => bcrypt('test4'),
            'avatar' => 'sample_user4.jpg',
        ]);
    }
}
