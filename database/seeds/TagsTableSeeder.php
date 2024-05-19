<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currentDateTime = Carbon::now();

        DB::table('tags')->insert([
            'name' => '吉野家',
            'created_at' => $currentDateTime,
        ]);
        DB::table('tags')->insert([
            'name' => '松屋',
            'created_at' => $currentDateTime,
        ]);
        DB::table('tags')->insert([
            'name' => 'すき家',
            'created_at' => $currentDateTime,
        ]);
        DB::table('tags')->insert([
            'name' => 'なか卯',
            'created_at' => $currentDateTime,
        ]);
    }
}
