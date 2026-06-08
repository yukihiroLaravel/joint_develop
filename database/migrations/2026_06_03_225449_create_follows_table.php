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
            $table->bigInteger('following')->unsigned()->index();   // フォローしているユーザ
            $table->bigInteger('followed')->unsigned()->index();    // フォローされているユーザ
            $table->timestamps();
            $table->softDeletes(); // 論理削除
            // 外部キー制約
            $table->foreign('following')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('followed')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['following', 'followed']);
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
