<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currentDateTime = Carbon::now();
        
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' => 'test1が投稿した文１個目',  
            'created_at' => $currentDateTime,
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' => 'test1が投稿した文２個目',
            'created_at' => $currentDateTime,
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' => 'test1が投稿した文３個目',
            'created_at' => $currentDateTime,
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'content' => 'test2が投稿した文１個目',
            'created_at' => $currentDateTime, 
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'content' => 'test2が投稿した文２個目',
            'created_at' => $currentDateTime,  
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' => 'test1が投稿した文４個目',
            'created_at' => $currentDateTime, 
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'content' => 'test3が投稿した文１個目',
            'created_at' => $currentDateTime,
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'content' => 'test3が投稿した文２個目',
            'created_at' => $currentDateTime, 
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'content' => 'test3が投稿した文３個目',
            'created_at' => $currentDateTime, 
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'content' => 'test3が投稿した文４個目',
            'created_at' => $currentDateTime, 
        ]);
        DB::table('posts')->insert([
            'user_id' => 4,
            'content' => 'test4が投稿した文１個目',
            'created_at' => $currentDateTime,
        ]);        
    }
}
