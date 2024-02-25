<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('followed_user_id')->unsigned()->index();
            $table->bigInteger('following_user_id')->unsigned()->index();
            $table->timestamps();

             // フォローされたユーザーの外部キー制約
            $table->foreign('followed_user_id')->references('id')->on('users')->onDelete('cascade');

            // フォローしたユーザーの外部キー制約
            $table->foreign('following_user_id')->references('id')->on('users')->onDelete('cascade');

            // followed_user_id と following_user_id のペアが一意であることを保証
            $table->unique(['following_user_id', 'followed_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('followers');
    }
}
