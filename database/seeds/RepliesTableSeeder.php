<?php

use Illuminate\Database\Seeder;

class RepliesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('ja_JP');

        for($i = 1; $i <= 100; $i++){
            DB::table('replies')->insert([
                'comment' => $faker->realText(20),
                'user_id' => rand(1, 29),
                'post_id' => rand(1, 29),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}