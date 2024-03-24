<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('comment_user_id')->unsigned()->index();
            $table->bigInteger('commented_user_id')->unsigned()->index();
            $table->text('comment');
            $table->softDeletes();
            $table->timestamps();
            // 外部キー制約
            $table->foreign('comment_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('commented_user_id')->references('id')->on('users')->onDelete('cascade');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
