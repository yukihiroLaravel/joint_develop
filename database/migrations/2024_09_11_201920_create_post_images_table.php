<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
            1つ1つのファイルにuuidを割り振り、「uuid/file_name」のパスで画像ファイルをアップロードする。
            新規投稿時などでアップロードはしたが、最後、投稿ボタンを押さず、別画面に遷移してしまうケースもある。
            別投稿(別ユーザの投稿など)で同じファイル名がアップロードされた時の競合も回避しなければならない。
            様々なケースを考えると、「1つ1つのファイルにuuidを割り振り、「uuid/file_name」のパス」が
            最も簡単で不具合を起こしにくい。
            
            uuidと、file_nameの組み合わせに対して、画面上のアップロードUIの並び順を
            order項目として当テーブルに保存する。

            その状況をpostsに外部キーで紐づけ、各$postデータに紐づく、当テーブルのレコード値を
            order項目の順に画面表示ができるようにする。

            更新処理でマッチング処理をさせるのを避けたいため、当テーブルは、DELETE/INSERT
            で保存する方向性で考える。

            当テーブルを削除時は、物理削除とします。
        */
        Schema::create('post_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('post_id')->unsigned()->index();

            $table->bigInteger('order');
            $table->string('uuid');
            $table->string('file_name');

            $table->timestamps();

            //外部キー制約
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
        Schema::dropIfExists('post_images');
    }
}
