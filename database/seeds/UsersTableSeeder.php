<?php

use Illuminate\Database\Seeder;

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
            'name' => 'test1',
            'email' => 'test1@test.com',
            'password' => bcrypt('test1')
        ]);
        DB::table('users')->insert([
            'name' => 'test2',
            'email' => 'test2@test.com',
            'password' => bcrypt('test2')
        ]);
        DB::table('users')->insert([
            'name' => 'test3',
            'email' => 'test3@test.com',
            'password' => bcrypt('test3')
        ]);
        DB::table('users')->insert([
            'name' => 'test4',
            'email' => 'test4@test.com',
            'password' => bcrypt('test4')
        ]);

        // ユーザを8人追加
        for ($i = 5; $i <= 12; $i++) {
            DB::table('users')->insert([
                'name' => 'test' . $i,
                'email' => 'test' . $i . '@test.com',
                'password' => bcrypt('test' . $i),
                'created_at' => now(),
            ]);
        }
    }
}
