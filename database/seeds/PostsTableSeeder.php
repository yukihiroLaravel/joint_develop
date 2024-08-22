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
        //テスト代入件数　30件

        for($i = 1; $i < 31; $i++){
            DB::table('posts')->insert([
                'user_id'=> $i,
                'content'=> $i.'番です',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
    } 
}
