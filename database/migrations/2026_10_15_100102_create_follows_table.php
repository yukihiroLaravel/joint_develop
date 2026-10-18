<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('follower_id'); // フォローする側
            $table->unsignedBigInteger('followed_id'); // フォローされる側
            $table->timestamps();

            // 外部キー制約（ユーザ削除時にフォローも削除）
            $table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('followed_id')->references('id')->on('users')->onDelete('cascade');

            // ユニーク制約（同じユーザを重複フォロー出来ないようにする）
            $table->unique(['follower_id', 'followed_id']);

            // フォローされている側からの検索を高速化するためのインデックス
            $table->index('followed_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follows');
    }
}
