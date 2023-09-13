<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('favorites')->insert([
            'user_id' => 1,
            'post_id' => 2,
        ]);
        DB::table('favorites')->insert([
            'user_id' => 3,
            'post_id' => 2,
        ]);
        DB::table('favorites')->insert([
            'user_id' => 4,
            'post_id' => 2,
        ]);
        DB::table('favorites')->insert([
            'user_id' => 5,
            'post_id' => 2,
        ]);
        DB::table('favorites')->insert([
            'user_id' => 6,
            'post_id' => 2,
        ]);
        DB::table('favorites')->insert([
            'user_id' => 2,
            'post_id' => 1,
        ]);
        DB::table('favorites')->insert([
            'user_id' => 3,
            'post_id' => 1,
        ]);
        DB::table('favorites')->insert([
            'user_id' => 4,
            'post_id' => 1,
        ]);
        DB::table('favorites')->insert([
            'user_id' => 5,
            'post_id' => 1,
        ]);
        DB::table('favorites')->insert([
            'user_id' => 1,
            'post_id' => 3,
        ]);
        DB::table('favorites')->insert([
            'user_id' => 2,
            'post_id' => 3,
        ]);
        DB::table('favorites')->insert([
            'user_id' => 1,
            'post_id' => 9,
        ]);
        DB::table('favorites')->insert([
            'user_id' => 3,
            'post_id' => 9,
        ]);
        DB::table('favorites')->insert([
            'user_id' => 4,
            'post_id' => 9,
        ]);
        DB::table('favorites')->insert([
            'user_id' => 5,
            'post_id' => 9,
        ]);
    }
}
