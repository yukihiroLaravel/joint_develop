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
            'password' => bcrypt('test1')
        ]);
        DB::table('users')->insert([
            'name' => 'test2',
            'email' => 'test2@test.com',
            'password' => bcrypt('test2')
        ]);
        DB::table('users')->insert([
            'name' => 'test3',
            'email' => 'test3@test.com',
            'password' => bcrypt('test3')
        ]);
        DB::table('users')->insert([
            'name' => 'test4',
            'email' => 'test4@test.com',
            'password' => bcrypt('test4')
        ]);
        DB::table('users')->insert([
            'name' => 'test5',
            'email' => 'test5@test.com',
            'password' => bcrypt('test5')
        ]);
        DB::table('users')->insert([
            'name' => 'test6',
            'email' => 'test6@test.com',
            'password' => bcrypt('test6')
        ]);
        DB::table('users')->insert([
            'name' => 'test7',
            'email' => 'test7@test.com',
            'password' => bcrypt('test7')
        ]);
        DB::table('users')->insert([
            'name' => 'test8',
            'email' => 'test8@test.com',
            'password' => bcrypt('test8')
        ]);
        DB::table('users')->insert([
            'name' => 'test9',
            'email' => 'test9@test.com',
            'password' => bcrypt('test9')
        ]);
        DB::table('users')->insert([
            'name' => 'test10',
            'email' => 'test10@test.com',
            'password' => bcrypt('test10')
        ]);
        DB::table('users')->insert([
            'name' => 'test11',
            'email' => 'test11@test.com',
            'password' => bcrypt('test11')
        ]);
        DB::table('users')->insert([
            'name' => 'test12',
            'email' => 'test12@test.com',
            'password' => bcrypt('test12')
        ]);
    }
}

