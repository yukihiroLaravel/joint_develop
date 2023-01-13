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
            'name' => 'kishio',
            'email' => 'kishio@test.com',
            'password' => bcrypt('test1')
        ]);
        DB::table('users')->insert([
            'name' => 'fujioka',
            'email' => 'fujioka@test.com',
            'password' => bcrypt('test2')
        ]);
        DB::table('users')->insert([
            'name' => 'goto',
            'email' => 'goto@test.com',
            'password' => bcrypt('test3')
        ]);
        DB::table('users')->insert([
            'name' => 'otubo',
            'email' => 'otubo@test.com',
            'password' => bcrypt('test4')
        ]);
    }
}
