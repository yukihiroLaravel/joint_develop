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

            // カラムを先に作成し、後から外部キー制約を設定
            $table->unsignedBigInteger('follower_id'); // フォロワーID
            $table->foreign('follower_id')->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('followed_id'); // フォローされる側のユーザID
            $table->foreign('followed_id')->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
            $table->unique(['follower_id', 'followed_id']);  // 同じフォロー関係が重複しないように
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
