<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1から4まで繰り返し、ユーザを新規作成する
        for ($i = 1; $i <= 4; $i++) {
            DB::table('users')->insert([
                'name' => 'test' . $i,                  // name = test1
                'email' => 'test' . $i. '@test.com',    // email = test1@test.com
                'password' => bcrypt('test' . $i)       // password = test1
            ]);
        }
    }
}