<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [];

        for ($i = 1; $i <= 10; $i++) {
            $users[] = [
                'name' => 'test' . $i,
                'email' => 'test' . $i . '@test.com',
                'password' => bcrypt('test' . $i),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('users')->insert($users);
    }
}
