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
            $table->string('comment_content');
            $table->string('user_name');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->timestamps();
            $table->softDeletes();
            // 外部キー制約  
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');         });
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
