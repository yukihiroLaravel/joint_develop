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
        for ($num = 1; $num < 6; $num++){
            DB::table('users')->insert([
                'name' => 'test'.$num,
                'email' => 'test'.$num.'@test.jp',
                'password' => bcrypt('test'.$num.'1pass')
            ]);
        }
    }
}
