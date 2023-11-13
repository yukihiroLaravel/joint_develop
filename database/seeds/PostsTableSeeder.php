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
            'user_id' => 1,
            'content' => '今までに行ったことのあるオススメのお店や美味しかった料理・気になっている食べ物について語ろう。',
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'content' =>"おでんが好きです。"
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'content' =>"博多もつ鍋やま中のもつ鍋がおいしい"
        ]);
        DB::table('posts')->insert([
            'user_id' => 4,
            'content' =>"京のおばんざい処 六角や のおばんざいは人気があります"
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' =>"渋いですね!!"
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'content' =>"金沢は意外と 寿司が有名です"
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'content' =>"私はラーメンが好きです"
        ]);
        DB::table('posts')->insert([
            'user_id' => 4,
            'content' =>"京都に第一旭といって6:00~翌1:00時までほぼ24時間空いている有名なラーメン屋があります。"
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' =>"山梨県は ワインが有名ですね!!"
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'content' =>"私もお酒は好きです"
        ]);
        DB::table('posts')->insert([
            'user_id' => 3,
            'content' =>"他にも ほうとう なども有名ですね"
        ]);
        }
    }

