<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Post;

class RepliesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $posts = Post::all();

        if ($users->count() === 0 || $posts->count() === 0) {
            $this->command->info('ユーザまたは投稿が存在しないため、返信を作成しません。');
            return;
        }

        // 300件くらいの返信を生成
        for ($i = 1; $i <= 300; $i++) {
            DB::table('replies')->insert([
                'user_id' => $users->random()->id,
                'post_id' => $posts->random()->id,
                'content' => 'これはテスト返信' . $i . 'です。',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
