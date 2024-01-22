<?php

use Illuminate\Database\Seeder;

class ReplyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 100; $i++){
            DB::table('replies')->insert([
                'content' => 'これは' .$i .'個目の返信です。',
                'user_id' => rand(1, 5),
                'post_id' => rand(1,200),
            ]);
        }
    }
}
