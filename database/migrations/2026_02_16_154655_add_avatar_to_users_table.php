<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvatarToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // avatar という名前の文字列カラムを追加
            // nullable() は「画像がなくてもOK」という意味
            // after('name') は「nameカラムの後ろに追加する」という配置の指定です
            $table->string('avatar')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations. (指示を取り消す)
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // ロールバック（取り消し）した時に、追加したカラムを削除するようにします
            $table->dropColumn('avatar');
        });
    }
}
