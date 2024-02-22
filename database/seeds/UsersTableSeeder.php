<?php

use Illuminate\Database\Seeder;
use App\User;

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
            ['name' => 'AAA', 'email' => 'AAA@AAA.com', 'password' => bcrypt('AAAAAAAA')],
            ['name' => 'BBB', 'email' => 'BBB@BBB.com', 'password' => bcrypt('BBBBBBBB')],
            ['name' => 'CCC', 'email' => 'CCC@CCC.com', 'password' => bcrypt('CCCCCCCC')],
            ['name' => 'DDD', 'email' => 'DDD@DDD.com', 'password' => bcrypt('DDDDDDDD')],
        ];

        foreach ($usersData as $userData) {
            DB::table('users')->insert($userData);
        }
    }
}
