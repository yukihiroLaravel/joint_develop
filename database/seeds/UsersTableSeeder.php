<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // for ($i = 1; $i <= 10; $i++) {
        //     User::create([
        //         'name' => 'user'. $i,
        //         'email' => 'user'. $i. '@test.com',
        //         'password' => Hash::make('password'),
        //     ]);
        // }

        DB::table('users')->insert([
            'name' => 'yamada',
            'email' => 'yamada@test.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'nisida',
            'email' => 'nisida@test.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'sakizono',
            'email' => 'sakizono@test.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'sugihara',
            'email' => 'sugihara@test.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'hirabayashi',
            'email' => 'hirabayashi@test.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'hashimoto',
            'email' => 'hashimoto@test.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
