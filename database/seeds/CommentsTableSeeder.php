<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = now()->startOfDay();
        $currentDate = (clone $date)->addDays();

        for ($i = 1; $i <= 4; $i++) {
            $currentDate = (clone $date)->addDays($i - 1);
        
            DB::table('comments')->insert([
                'user_id' =>  $i,
                'content' => '最初のコメントです',
                'created_at' => $currentDate,
                'updated_at' => $currentDate,
            ]);
        }
    }
}