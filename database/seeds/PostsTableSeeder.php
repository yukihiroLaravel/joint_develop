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
            'content' => 'PHPの最新版を使用し、セキュリティを強化することで、ウェブアプリケーションの脆弱性を最小限に抑えることができます。',
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'content' => 'Laravelなどのフレームワークを活用することで、効率的な開発を実現し、プロジェクトの生産性を向上させることができます。',
            'user_id' => 2,
        ]);
        DB::table('posts')->insert([
            'content' => 'Composerを使って外部ライブラリを簡単に管理することで、開発プロセスをスムーズにし、再利用性を高めることができます。',
            'user_id' => 3,
        ]);
        DB::table('posts')->insert([
            'content' => 'PHP拡張モジュールを利用してパフォーマンスを最適化し、ユーザーエクスペリエンスを向上させることができます。',
            'user_id' => 4,
        ]);
        DB::table('posts')->insert([
            'content' => 'PSR準拠のコーディングスタイルを採用することで、コードの可読性を高め、メンテナンス性を向上させます。',
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'content' => 'PHPDocを使用してコードに適切なドキュメンテーションを追加することで、チームメンバー間でのコードの理解を容易にします。',
            'user_id' => 2,
        ]);
        DB::table('posts')->insert([
            'content' => 'PDOを使用してセキュアなデータベース操作を行うことで、SQLインジェクションなどのセキュリティ脅威からアプリケーションを守ることができます。',
            'user_id' => 3,
        ]);
        DB::table('posts')->insert([
            'content' => 'XSSやSQLインジェクションなどのセキュリティ脅威に対する適切な対策を実装することで、ユーザーのデータを保護します。',
            'user_id' => 4,
        ]);
        DB::table('posts')->insert([
            'content' => ' ユニットテストや統合テストを通じて、品質を確保し、バグを早期に発見して修正することができます。',
            'user_id' => 1,
        ]);
        DB::table('posts')->insert([
            'content' => 'マルチスレッド処理に対応することで、複数のタスクを同時に処理し、アプリケーションのパフォーマンスを向上させることができます。',
            'user_id' => 2,
        ]);
        DB::table('posts')->insert([
            'content' => 'キャッシュ機構を導入して、データベースアクセスや計算結果の再利用を促進し、処理速度を向上させます。',
            'user_id' => 3,
        ]);
        DB::table('posts')->insert([
            'content' => 'コミュニティやオンラインリソースを活用して、最新のベストプラクティスやトレンドを学び、自己成長を促進します。',
            'user_id' => 4,
        ]);
    }
}

