<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    // マイグレーションファイル（DBテーブルの履歴を管理するファイル）

    public function up() //投稿する。
    {
        Schema::create('posts', function (Blueprint $table) { // マイグレーションは複数形。モデルは単数系。laravel側で自動判定。
            $table->bigIncrements('id'); // 主キー。idが自動的に追加。
            $table->string('content', 140); // 投稿内容。
            $table->bigInteger('user_id')->unsigned()->index(); // ユーザーのid。マイナス符号がない大きい整数。indexで検索しやすい。
            $table->timestamps(); // メソッドが実行された時間（投稿した時間）
            $table->softDeletes(); // 論理削除(優しい削除)

            // 外部キー制約
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // ユーザーテーブルのidとポストテーブルのuser_idを外部キー制約。
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
