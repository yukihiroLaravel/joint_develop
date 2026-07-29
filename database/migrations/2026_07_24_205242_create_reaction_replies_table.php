<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReactionRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reaction_replies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reaction_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('content', 100);
            $table->timestamps();
            $table->foreign('reaction_id')
                  ->references('id')
                  ->on('reactions')
                  ->onDelete('cascade');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reaction_replies');
    }
}
