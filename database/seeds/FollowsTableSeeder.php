<?php

use Illuminate\Database\Seeder;

class FollowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i<=9; $i++) {
            DB::table('follows')->insert([
                'following' => $i,
                'followed' => $i+1
            ]);
            if ($i <= 8) {
                DB::table('follows')->insert([
                    'following' => $i,
                    'followed' => $i+2
                ]);
                if ($i <= 7) {
                    DB::table('follows')->insert([
                        'following' => $i,
                        'followed' => $i+3
                    ]);
                }
            }
        }
    }
}
