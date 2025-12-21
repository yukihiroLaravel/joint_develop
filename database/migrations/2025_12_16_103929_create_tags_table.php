<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            // 作成者（ログインユーザー）
            $table->unsignedBigInteger('user_id');
            // 更新回数（1回まで）
            $table->unsignedTinyInteger('update_count')->default(0);
            $table->timestamps();
             // 外部キー制約
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
    }
}
