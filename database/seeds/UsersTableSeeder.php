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
        for ($i = 1; $i < 4; $i++) {
            DB::table('users')->insert([
                'name' => 'ユーザ'.$i.'番',
                'email' => 'sample'.$i.'@sample.com',
                'password' => bcrypt('sample'.$i),
            ]);
        }
    }
}
