<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

public function run()
{
    DB::table('posts')->insert([
        'content' => 'これはテスト用の投稿本文です。',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

