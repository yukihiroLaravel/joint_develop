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
            'name' => 'masaki',
            'email' => 'test1@test.com',
            'password' => bcrypt('test1')
        ]);
        DB::table('users')->insert([
            'name' => 'kazuhumi',
            'email' => 'test2@test.com',
            'password' => bcrypt('test2')
        ]);
        DB::table('users')->insert([
            'name' => 'kumiko',
            'email' => 'test3@test.com',
            'password' => bcrypt('test3')
        ]);
        DB::table('users')->insert([
            'name' => 'murai',
            'email' => 'test4@test.com',
            'password' => bcrypt('test4')
        ]);
    }
}
