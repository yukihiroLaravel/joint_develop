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
            'name' => 'ミッキー',
            'email' => 'test1@test.com',
            'password' => bcrypt('test1')
        ]);
        DB::table('users')->insert([
            'name' => 'ミニー',
            'email' => 'test2@test.com',
            'password' => bcrypt('test2')
        ]);
        DB::table('users')->insert([
            'name' => 'ドナルド',
            'email' => 'test3@test.com',
            'password' => bcrypt('test3')
        ]);
        DB::table('users')->insert([
            'name' => 'プルート',
            'email' => 'test4@test.com',
            'password' => bcrypt('test4')
        ]);
    }
}
