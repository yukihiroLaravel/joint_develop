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
            'name' => '健太',
            'email' => 'kenta@test.com',
            'password' => bcrypt('Kenta'),
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => 'Katsu',
            'email' => 'Katsu@test.com',
            'password' => bcrypt('Katsu'),
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => '橋本',
            'email' => 'Hashimoto@test.com',
            'password' => bcrypt('Hashimoto'),
            'created_at' => now()
        ]);
    }
}
