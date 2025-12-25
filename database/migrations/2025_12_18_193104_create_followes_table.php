<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowesTable extends Migration
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
        $table->bigInteger('follow_id')->unsigned();
        $table->bigInteger('followed_id')->unsigned();
        $table->timestamps();
        
        $table->foreign('follow_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('followed_id')->references('id')->on('users')->onDelete('cascade');

        $table->unique(['follow_id', 'followed_id']);
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
