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
            $table->bigInteger('following_id')->unsigned()->index(); // フォロー元
            $table->bigInteger('followed_id')->unsigned()->index(); // フォロー先
            $table->timestamps();
            $table->softDeletes();
            // 外部キー制約
            $table->foreign('following_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('followed_id')->references('id')->on('users')->onDelete('cascade');
            // 組み合わせの重複禁止
            $table->unique(['following_id', 'followed_id']);
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
