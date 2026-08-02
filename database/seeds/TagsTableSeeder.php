<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
        ['type' => 'マイスポット'],
        ['type' => '今日の空／気分'],
        ['type' => 'お役立ち情報'],
        ['type' => 'マイルーティン'],
        ['type' => '今日のごはん・おやつ'],
        ['type' => '今日のひとこと（つぶやき）'],
        ['type' => '珍しい名字・地名'],
        ]);
    }
}
