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
        for($val = 1; $val <= 15; $val++){
            DB::table('users')->insert([
                'name' => 'test'.$val,
                'email' => 'test'.$val.'@test.com',
                'password' => bcrypt('test'.$val),
                'created_at' => now()
            ]);
        }
    }
}
