<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReplysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('post_id')->unsigned();
            $table->string('reply');
            $table->timestamps();
            $table->softDeletes();
            // 外部キー制約
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replys');
    }
}
