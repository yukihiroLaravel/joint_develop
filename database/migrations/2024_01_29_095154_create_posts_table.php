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
            $table->string('text'); //追記
            $table->bigInteger('user_id')->unsigned()->index(); //追記
            $table->timestamps(); //追記
            $table->softDeletes(); //追記
           
            // 外部キー制約
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); //追記
            
    });
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
