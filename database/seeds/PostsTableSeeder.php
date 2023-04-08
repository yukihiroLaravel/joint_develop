<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($val = 1; $val <= 15; $val++) {
            DB::table('posts')->insert([
                'text' => 'test'.$val,
                'user_id' => $val,
                'created_at' => now()
            ]);
        }
    }
}
