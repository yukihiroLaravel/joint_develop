<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\User;


class PostsTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        if ($users->count() === 0) {
            $this->command->info('ユーザが存在しないため、投稿を作成しません。');
            return;
        }

        for ($i = 1; $i <= 330; $i++) {
            DB::table('posts')->insert([
                'user_id' => $users->random()->id,
                'content' => 'これはテスト投稿その' . $i . 'です。',
                'created_at' => now(),
                'updated_at' => now(),
           ]);
        }
    }
}

