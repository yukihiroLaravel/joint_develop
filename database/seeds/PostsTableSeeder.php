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
        for ($val = 0; $val <= 9; $val++) {
            DB::table('posts')->insert([
                'text' => 'test'.$val,
                'user_id' => $val + 1,
            ]);
        }
    }
}
