<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $min = 1;
        $max = 10;

        foreach (range(1, 10) as $index) {
            $createdAt = $faker->dateTimeBetween('-1 year', 'now');

            DB::table('posts')->insert([
                'user_id' => $faker->numberBetween($min, $max),
                'content' => $faker->paragraph,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}
