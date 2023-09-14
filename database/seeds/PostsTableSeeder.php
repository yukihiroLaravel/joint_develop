<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'text' => '窓掃除は湿度の高いくもりの日が最適',
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'text' => 'ほうれん草のゆで汁で衣類のシミを落とせる',
            'user_id' => 2,
        ]);
        DB::table('posts')->insert([
            'text' => '薄手生地の脱水にはバスタオルを活用',
            'user_id' => 3,
        ]);
    }
}
