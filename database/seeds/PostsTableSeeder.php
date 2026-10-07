<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = DB::table('users')->pluck('id')->toArray();

        if (empty($userIds)) {
            $this->command->warn('No users found. Please run UsersTableSeeder first.');
            return;
        }

        $posts = [];
        $sampleContents = [
            'Laravelの学習を始めました。',
            'Dockerで開発環境を整えました。',
            'マイグレーションとSeederの確認中です。',
            '今日は新しい機能を試しています。',
            'コードレビューの時間です。',
            'データベース設計を見直しています。',
            'ローカル環境の設定が進みました。',
            'テストが通るととても嬉しいです。',
            '今日は少しずつ進捗があります。',
            'サンプル投稿を12件作成しています。',
            'Laravelの理解が深まってきました。',
            '次はUI改善に取り組みます。',
        ];

        foreach ($sampleContents as $index => $content) {
            $posts[] = [
                'content' => $content,
                'user_id' => $userIds[$index % count($userIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('posts')->insert($posts);
    }
}
