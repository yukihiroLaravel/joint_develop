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
        $maleNames = [
            '山田 太郎', '鈴木 修', '佐藤 健', '田中 実', '高橋 誠',
            '伊藤 敏', '渡辺 亮', '中村 剛', '小林 勇', '加藤 健太',
            '吉田 和也', '山本 弘', '松本 直樹', '斉藤 忠', '佐々木 仁',
            '井上 直人', '木村 亮介', '林 信', '清水 翔', '山口 剛志'
        ];

        $femaleNames = [
            '山田 花子', '鈴木 美咲', '佐藤 真由美', '田中 美奈子', '高橋 美穂',
            '伊藤 彩', '渡辺 美和', '中村 由紀', '小林 里奈', '加藤 綾香',
            '吉田 真理子', '山本 愛', '松本 理恵', '斉藤 美佳', '佐々木 由美',
            '井上 絵里', '木村 奈々', '林 美樹', '清水 綾', '山口 純子'
        ];

        for ($i = 1; $i <= 100; $i++) {
            $isMale = rand(0, 1) == 1;
            $nameList = $isMale ? $maleNames : $femaleNames;
            $name = $nameList[array_rand($nameList)];
            
            DB::table('users')->insert([
                'name' => $name,
                'email' => "test" . $i . "@test.com",
                'password' => bcrypt("test" . $i)
            ]);
        }
    }
}
