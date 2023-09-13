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
            [
                'name' =>'nari',
                'email' => 'nari@.com',
                'password' => bcrypt('nari'),
            ],
        ]);
        DB::table('users')->insert([
            [
                'name' =>'seiichi',
                'email' => 'seiichi@.com',
                'password' => bcrypt('seiichi'),
            ],
        ]);
        DB::table('users')->insert([
            [
                'name' =>'jyunpei',
                'email' => 'jyunpei@.com',
                'password' => bcrypt('jyunpei'),
            ],
        ]);
    }
}