<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReplies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('content', 140); 
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')      //外部キー制約
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('post_id');   //返信している投稿のid
            $table->foreign('post_id')       //外部キー制約
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replies');
    }
}
