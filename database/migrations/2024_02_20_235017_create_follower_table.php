<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowerTable extends Migration
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
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('followed_user_id')->unsigned()->index();
            $table->timestamps();

             // フォローしたユーザーの外部キー制約
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // フォローされたユーザーの外部キー制約
            $table->foreign('followed_user_id')->references('id')->on('users')->onDelete('cascade');

            // user_id と followed_user_id のペアが一意であることを保証
            $table->unique(['user_id', 'followed_user_id']);
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
