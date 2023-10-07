<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFollowerAndFollowingColumnsFromFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 外部キー制約を削除
        Schema::table('follows', function (Blueprint $table) {
            $table->dropForeign(['follower_id']);
        });
        // 外部キー制約を削除
        Schema::table('follows', function (Blueprint $table) {
            $table->dropForeign(['following_id']);
        });
        Schema::table('follows', function (Blueprint $table) {
            // follower_id カラムを削除
            $table->dropColumn('follower_id');

            // following_id カラムを削除
            $table->dropColumn('following_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('follows', function (Blueprint $table) {
            //
        });
    }
}
