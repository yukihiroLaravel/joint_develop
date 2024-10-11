<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_post', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->unsigned()->index();
            $table->bigInteger('post_id')->unsigned()->index();

            /*
                特記事項（その１）
                    マッチング処理が大変なため、DELETE/INSERTでの入れ直しをすることにした。

                    この中間テーブルのcreated_at、updated_atの項目に全く意味を見出せなかった。
                    不要なので指定しないことにした。

                あえてコメントアウトしたコードは、以下のとおり
                
                $table->timestamps();
            */

            /*
                特記事項（その２）
                    あえて外部キー制約はつけないことにした。
                    belongsToMany()などでの関連付けがしたいわけではなく
                    検索機能で、クエリビルダに対して
                    joinする形での絞り込み検索がしたいだけである。
                    「categories」のデータは、仕様にあわせて変動の余地がある。
                    その際に、ガチガチに外部キー制約をつけてると
                    データの削除や入れ直しのなど仕様にあわせたメンテナンスがしにくい状況となる
                    外部キー的な使い方をする項目に、「->index()」でのインデックスをはっておけば十分である。
                    その項目がjoinでの結合条件となり、インデックスで高速化されるはずだから。

                あえてコメントアウトしたコードは、以下のとおり
                
                // 外部キー制約
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
                $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_post');
    }
}
