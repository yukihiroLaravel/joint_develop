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
        DB::table('users')->insert([
            'name' => '健太',
            'email' => 'kenta1@test.com',
            'password' => bcrypt('Kenta'),
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => 'Katsu',
            'email' => 'Katsu1@test.com',
            'password' => bcrypt('Katsu'),
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => '橋本',
            'email' => 'Hashimoto1@test.com',
            'password' => bcrypt('Hashimoto'),
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => '健太',
            'email' => 'kenta2@test.com',
            'password' => bcrypt('Kenta'),
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => 'Katsu',
            'email' => 'Katsu2@test.com',
            'password' => bcrypt('Katsu'),
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => '橋本',
            'email' => 'Hashimoto3@test.com',
            'password' => bcrypt('Hashimoto'),
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => '健太',
            'email' => 'kenta4@test.com',
            'password' => bcrypt('Kenta'),
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => 'Katsu',
            'email' => 'Katsu4@test.com',
            'password' => bcrypt('Katsu'),
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => '橋本',
            'email' => 'Hashimoto4@test.com',
            'password' => bcrypt('Hashimoto'),
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => '健太',
            'email' => 'kenta5@test.com',
            'password' => bcrypt('Kenta'),
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => 'Katsu',
            'email' => 'Katsu5@test.com',
            'password' => bcrypt('Katsu'),
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => '橋本',
            'email' => 'Hashimoto5@test.com',
            'password' => bcrypt('Hashimoto'),
            'created_at' => now()
        ]);
    }
}
