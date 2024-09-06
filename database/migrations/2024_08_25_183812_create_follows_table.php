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
        // ************************************************************************************
        // 想定のデータ例)
        // 1) 下記「id=1のデータ」 user_id=3がuser_id=5をフォローしている
        // 2) 下記「id=2のデータ」 user_id=5がuser_id=3をフォローしている
        // 3) 下記「id=3のデータ」 user_id=4がuser_id=5をフォローしている
        // 4) 下記「id=4のデータ」 user_id=6がuser_id=5をフォローしている
        // 5) 下記「id=5のデータ」 user_id=3がuser_id=4をフォローしている
        //
        // id  from_user_id  to_user_id  created_at        updated_at
        // 1   3             5           フォローした日時   フォローした日時
        // 2   5             3           フォローした日時   フォローした日時
        // 3   4             5           フォローした日時   フォローした日時
        // 4   6             5           フォローした日時   フォローした日時
        // 5   3             4           フォローした日時   フォローした日時
        //
        // フォロー解除は、followsの物理削除とします。
        // ************************************************************************************

        Schema::create('follows', function (Blueprint $table) {
            $table->bigIncrements('id');
            // フォローしている側のUserのid
            $table->bigInteger('from_user_id')->unsigned()->index();
            // フォローされている側のUserのid
            $table->bigInteger('to_user_id')->unsigned()->index();
            $table->timestamps();

            // 外部キー制約
            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade');

            // ユニーク制約
            $table->unique(['from_user_id', 'to_user_id']);
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
