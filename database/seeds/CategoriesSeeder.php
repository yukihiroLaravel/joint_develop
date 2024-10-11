<?php

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $order = 0;

        DB::table('categories')->insert([
            ['name' => '世界政府の陰謀', 'order' => ++$order, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'イルミナティ', 'order' => ++$order, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '新世界秩序', 'order' => ++$order, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '宇宙人とUFO', 'order' => ++$order, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'フリーメイソン', 'order' => ++$order, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '9/11同時多発テロ陰謀説', 'order' => ++$order, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ワクチン陰謀論', 'order' => ++$order, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '月面着陸は捏造', 'order' => ++$order, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '人工気象操作', 'order' => ++$order, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'メディアコントロール', 'order' => ++$order, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '金融エリートの陰謀', 'order' => ++$order, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '人口削減計画', 'order' => ++$order, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '気象兵器の存在', 'order' => ++$order, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ディープステートの支配', 'order' => ++$order, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '遺伝子操作と人間の未来', 'order' => ++$order, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '歴史の改ざん', 'order' => ++$order, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '地球空洞説', 'order' => ++$order, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '月面の秘密基地', 'order' => ++$order, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '人工ウイルスによるパンデミック', 'order' => ++$order, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '監視社会とビッグデータの陰謀', 'order' => ++$order, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
