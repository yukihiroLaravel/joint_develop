<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            'Laravel',
            'PHP',
            '初心者',
            'Web',
            'バックエンド',
        ];
        
        foreach ($tags as $name) {
            Tag::firstOrCreate(['name' => $name]);
        }
    }
}
