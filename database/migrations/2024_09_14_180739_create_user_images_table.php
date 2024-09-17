<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
            当「user_images」テーブルについて、
            「users」と「user_images」の関係が1対1または、1対0

            「post_images」と同様、「uuid/file_name」のパスで画像ファイルをアップロードした情報の管理だが
            uuidと、file_nameの組み合わせにを最大1個まで保持できればよいため、order項目はない。

            アップロードしたアバター画像のuuidと、file_nameの組み合わせの管理に用いる。

            当テーブルを削除時は、物理削除とします。
        */
        Schema::create('user_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();

            $table->string('uuid');
            $table->string('file_name');

            $table->timestamps();

            //外部キー制約
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
        Schema::dropIfExists('user_images');
    }
}
