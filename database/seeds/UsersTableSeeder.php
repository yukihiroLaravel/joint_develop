<?php

use Illuminate\Database\Seeder;
use App\User;
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

        for ($i=1; $i <=5 ; $i++) { 
           DB::table('users')->insert([
               [
                   'name' => 'テストゴルファー' . $i,
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
