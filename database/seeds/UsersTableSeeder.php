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
            'name' => '家出 太郎',
            'email' => 'test1@test.com',
            'password' => bcrypt('test1')
        ]);
        DB::table('users')->insert([
            'name' => '屋根裏 次郎',
            'email' => 'test2@test.com',
            'password' => bcrypt('test2')
        ]);
        DB::table('users')->insert([
            'name' => 'インドア ジョン',
            'email' => 'test3@test.com',
            'password' => bcrypt('test3')
        ]);
        DB::table('users')->insert([
            'name' => '手須戸',
            'email' => 'test4@test.com',
            'password' => bcrypt('test4')
        ]);
    }
}
