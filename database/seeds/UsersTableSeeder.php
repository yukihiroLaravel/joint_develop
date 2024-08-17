<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fakerインスタンスを英語設定で作成
        $faker = Faker::create('en_US');
        
        // 1から4まで繰り返し、ユーザを新規作成する
        for ($i = 1; $i <= 5; $i++) {
            // ランダムな一意な名前を生成（例：Ariel）
            $name = $faker->unique()->firstName;
            // 名前+@example.com （例：Ariel@example.com）
            $email = $name . '@example.com';
            
            DB::table('users')->insert([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt('pass') // password = pass
            ]);
        }
    }
}