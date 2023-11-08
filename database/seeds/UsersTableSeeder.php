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
        for ( $i=1; $i <= 8; $i++ ) {
            DB::table('users')->insert([
                'name' => 'testuser'.$i,
                'email' => 'testuser'.$i.'@test.com',
                'password' => bcrypt('testuser'.$i)
            ]);
        }
    }
}
