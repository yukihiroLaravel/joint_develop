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
        DB::table('posts')->insert([
            'text' => '防虫剤は衣類の上に除湿剤は衣類の下に入れると効果的',
            'user_id' => 4,
        ]);
        DB::table('posts')->insert([
            'text' => '手元に定規やメジャーが無い時は1,000円札の長さが約15㎝なので、これを利用出来る。',
            'user_id' => 5,
        ]);
    }
}
