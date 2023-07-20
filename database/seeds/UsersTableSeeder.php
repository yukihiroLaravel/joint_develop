<?php

use Illuminate\Database\Seeder;
use App\User;
// use Illuminate\Support\Str;  
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
        // DB::table('users')->insert([
        //     [
        //         'name' => 'テストユーザー1',
        //         'email'     => 'test1@test.com',
        //         'email_verified_at' => now(),
        //         'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //         'password' => bcrypt('password'),
        //         'remember_token' => Str::random(10),
        //     ],
        //     [
        //         'name' => 'テストユーザー2',
        //         'email'     => 'test2@test.com',
        //         'email_verified_at' => now(),
        //         'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //         'remember_token' => Str::random(10),
        //     ]
        // ]);

        for ($i=1; $i <=2 ; $i++) { 
            DB::table('users')->insert([
                    [
                        'name' => 'テストユーザー' . $i,
                        'email'     => 'test' . $i . '@test.com',
                        'email_verified_at' => now(),
                        'password' => bcrypt('password'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
            ]);
        }

        factory(User::class, 10)->create();
    }
}
