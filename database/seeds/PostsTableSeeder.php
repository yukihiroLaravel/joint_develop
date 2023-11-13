<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        for ($i = 1; $i < 100; $i++)
        {
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' => "test".$i,
        ]);
    
    }
 }
}


    
        