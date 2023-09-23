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
        for ( $i = 1; $i < 6; $i++ ) {
            DB::table('posts')->insert([
                'user_id' => $i,
                'content' => 'Test Message'.$i,
            ]);
        };
        for ( $i = 1; $i < 6; $i++ ) {
            DB::table('posts')->insert([
                'user_id' => $i,
                'content' => 'Congratulation testuser'.$i.'san',
            ]);
        };
    }
}
