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
            'user_id' => '2',
            'content' => 'オニダルマオコゼを料理します！背びれは毒があるのでお気をつけて！！',
            'image' => 'posts/2Jx2jQTds4DYTXuxrQp7ErBAp7CzwZXd6AYqMGZS.jpg',
            'created_at' => now(),
            ]);
        DB::table('posts')->insert([
            'user_id' => '3',
            'content' => '戸隠キャンプ場に行ってきました！浅瀬で川遊びもできて子供がいても楽しめます',
            'image' => 'posts/Zxb7Q07uuAdrYoZAdUKLFV9fezdIdHtV3jbXpViG.jpg',
            'created_at' => now(),
            ]);
        DB::table('posts')->insert([
            'user_id' => '2',
            'content' => '沖縄の残波岬で銛突きしてきました。遠浅の海岸なので魚のいるエリアまで結構泳ぎます😅フィンは必須ですね。本日の成果です',
            'image' => 'posts/0DVC4iFko1jPZJuw9UGg2qQ0ULh5pUIqGxVrqtZi.jpg',
            'created_at' => now(),
            ]);
        DB::table('posts')->insert([
            'user_id' => '5',
            'content' => 'シュノーケルで水中撮影が趣味の海人です。興味あればリプライください🥰',
            'image' => 'posts/fOcOuraPVDxB15YtPjdKCk8mOfiBBnM6qvTB43L8.jpg',
            'created_at' => now(),
            ]);
        DB::table('posts')->insert([
            'user_id' => '5',
            'content' => '波照間島でウミガメと泳いできました！最高に運が良かったです！！',
            'image' => 'posts/YNBjGxSgJoSSfx5ir6AzmgoTKFRXISmYliFo850I.jpg',
            'created_at' => now(),
            ]);
        DB::table('posts')->insert([
            'user_id' => '4',
            'content' => 'スノボー大好きです！おすすめのメーカーなどあったら教えてください😃',
            'image' => 'posts/kM2YA9rZIXQ85bguJdJapIyMc61l2erHTWu1uui6.jpg',
            'created_at' => now(),
            ]);
        DB::table('posts')->insert([
            'user_id' => '3',
            'content' => 'これぞキャンプの醍醐味！釣ったばかりの魚を焚き火焼きでいただきました。',
            'image' => 'posts/CU1pKB5chcPoemEB0yeQljr6Pbwga5HO1Sr1tmMO.jpg',
            'created_at' => now(),
            ]);
        DB::table('posts')->insert([
            'user_id' => '4',
            'content' => '標高2899m!八ヶ岳の赤岳に登ってきました！登山道も歩きやすく本格的な登山がしたい初心者の方におすすめです♪',
            'image' => 'posts/Jubec5VeklEMLlaa7hR96fOS0275FwT1dN5ODBFN.jpg',
            'created_at' => now(),
            ]);
        DB::table('posts')->insert([
            'user_id' => '5',
            'content' => '西表島で水中撮影！クマノミかわいい',
            'image' => 'posts/OdMHs00NjbdJxwnEAwoPaqusVciKAjAahvVoyPCV.jpg',
            'created_at' => now(),
            ]);
        DB::table('posts')->insert([
            'user_id' => '2',
            'content' => '本日の晩ご飯。タコは捕まえたら頭をひっくり返すと動かなくなります。',
            'image' => 'posts/6Fo4kEoxPIQWMhy2zL7enrsBNPZFvCB5PoYmqCia.jpg',
            'created_at' => now(),
            ]);
        DB::table('posts')->insert([
            'user_id' => '4',
            'content' => '愛用のテントはSnow peakのアメニティードームMです!',
            'created_at' => now(),
            ]);
        DB::table('posts')->insert([
            'user_id' => '4',
            'content' => '尾瀬の景色は最高です！登りも少なくハイキング感覚で行けます',
            'image' => 'posts/ODiuDSKsZVxZaC82b9AnvdcEtCNJpnZnRHSSDQJs.jpg',
            'created_at' => now(),
            ]);
    
    } 
}
