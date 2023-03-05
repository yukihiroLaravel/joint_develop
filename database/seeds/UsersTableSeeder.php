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
            'name' => 'azuma',
            'email' => 'azuma@test.com',
            'password' => bcrypt('test1'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'shibuya',
            'email' => 'shibuya@test.com',
            'password' => bcrypt('test2'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => '品川',
            'email' => 'shinagawa@test.com',
            'password' => bcrypt('test3'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'イケやん',
            'email' => 'ikeyan@test.com',
            'password' => bcrypt('test4'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'あっきー',
            'email' => 'aki@test.com',
            'password' => bcrypt('test5'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Okubo Arata',
            'email' => 'okuboarata@test.com',
            'password' => bcrypt('test6'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Megu',
            'email' => 'megu@test.com',
            'password' => bcrypt('test7'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'BB',
            'email' => 'bb@test.com',
            'password' => bcrypt('test8'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'chika',
            'email' => 'chika@test.com',
            'password' => bcrypt('test9'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'rin uxei',
            'email' => 'rinuxei@test.com',
            'password' => bcrypt('test10'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
