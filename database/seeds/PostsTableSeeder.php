<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $date = now()->startOfDay();

        for ($i = 1; $i <= 4; $i++) {
            $currentDate = (clone $date)->addDays($i - 1);

            DB::table('posts')->insert([
                'user_id' => $i,
                'content' => $faker->paragraph,
                'created_at' => $currentDate,
                'updated_at' => $currentDate,
            ]);
        }

    }
}


