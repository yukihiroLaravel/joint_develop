<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    
    public function run()
    {
        $faker = Faker::create();
        
        foreach (range(1, 30) as $index) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt('secret'),
            ]);
        }
    }
}