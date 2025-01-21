<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder_J extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array('masa', 'yurika', 'jin', 'laravel', 'joint');
        $time = Carbon::now();
        
        foreach ($users as $user) {
            DB::table('users')->insert([
                'nickname' => $user,
                'email' => $user.'@test.com',
                'password' => 'Laravel', // 固定値として
                'created_at' => $time,
                'updated_at' => $time,
            ]);
            $time = $time->addMinutes(10);
        }
        
    }
}