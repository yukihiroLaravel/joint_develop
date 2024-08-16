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
        // テスト投入の件数
        $insertCount = 30;

        for($index = 0 ; $index < $insertCount ; ++$index) {

            // 1はじまりindex の文字列
            $strIndexOneBase = strval($index + 1);

            $strCurrentName = 'テスト' . $strIndexOneBase;
            $strCurrentId = 'test' . $strIndexOneBase;
                
            DB::table('users')->insert([
                'name' => $strCurrentName,
                'email' => $strCurrentId .'@test.com',
                'password' => bcrypt($strCurrentId),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
