<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RepliesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // user_id が 4、post_id が 48 の投稿に対して12件のテストデータ作成
        for ($i = 1; $i <= 12; $i++) {
            DB::table('replies')->insert([
                'user_id' => (($i - 1) % 4) + 1, // 1から4までのuser_idを繰り返し
                'post_id' => 48,
                'content' =>  $i . '番目コメントです！',
                'created_at' => Carbon::create(2025, 2, 16, 12, 0, 0)->addSeconds($i * 60),
                'updated_at' => Carbon::create(2025, 2, 16, 12, 0, 0)->addSeconds($i * 60),
            ]);
        }
    }
}
