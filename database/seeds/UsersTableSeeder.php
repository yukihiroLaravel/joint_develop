<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        [
                'name' => 'test1',
                'email' => 'test1@test.com',
                'password' => bcrypt('test1'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'test2',
                'email' => 'test2@test.com',
                'password' => bcrypt('test2'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'test3',
                'email' => 'test3@test.com',
                'password' => bcrypt('test3'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'test4',
                'email' => 'test4@test.com',
                'password' => bcrypt('test4'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        for ($i = 5; $i <= 30; $i++) {
            DB::table('users')->insert([
                'name' => 'test' . $i,
                'email' => 'test' . $i . '@test.com',
                'password' => bcrypt('test' . $i),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}