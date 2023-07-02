<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('favorite_user_id')->unsigned();
            $table->bigInteger('favorite_post_id')->unsigned()->nullable();
            $table->bigInteger('favorite_comment_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('favorite_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('favorite_post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('favorite_comment_id')->references('id')->on('comments')->onDelete('cascade');
            $table->unique(['favorite_user_id', 'favorite_post_id']);
            $table->unique(['favorite_user_id', 'favorite_comment_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
