<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnusedFileCheckersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unused_file_checkers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('type');
            $table->bigInteger('check_count')->unsigned();
            
            $table->string('uuid');
            $table->string('file_name');

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
        Schema::dropIfExists('unused_file_checkers');
    }
}
