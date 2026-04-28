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
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 1');
        for ($i = 1; $i<=10; $i++) {
            DB::table('users')->insert([
                'name' => 'test'. $i,
                'email' => 'test'. $i. '@test.com',
                'password' => bcrypt('test'. $i)
            ]);
        }
    }
}
