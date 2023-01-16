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
        for ($i = 1; $i <= 10; $i++) {
        DB::table('users')->insert([
            'name' => 'ユーザ'.$i.'番',
            'email' => 'test'.$i.'@test.com',
            'password' => bcrypt('test'.$i),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        }
    }
}
