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
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name'); // エラー解消のため追加しました。
            $table->text('content');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->timestamps();
            // 新しい外部キー制約を追加
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // ソフトデリートのためのカラム追加
            $table->softDeletes();
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