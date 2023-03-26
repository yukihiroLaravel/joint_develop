<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('postss')->insert([
            'user_id' => 1,
            'text' => 'test',
        ]);

        DB::table('postss')->insert([
            'user_id' => 2,
            'text' => 'test',
        ]);

        DB::table('postss')->insert([
            'user_id' => 3,
            'text' => 'test',
        ]);
    }
}
