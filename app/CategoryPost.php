<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    protected $table = 'category_post';

    // created_at、updated_atの項目はないからfalse(trueだと実行時エラーになる)
    public $timestamps = false;

    protected $fillable = ['category_id', 'post_id'];

    /**
     * $postIdで抽出した、category_postのクエリビルダを取得する。
     */
    public static function getCategoryPostQueryByPostId($postId)
    {
        return self::where('post_id', $postId)->orderBy('category_id', 'asc');
    }

    /**
     * $postIdで抽出した、category_idの配列を取得する。
     */
    public static function getCategoryIdArrayByPostId($postId)
    {
        $queryBuilder = self::getCategoryPostQueryByPostId($postId);

        // category_idの1項目に射影して、配列にする
        $categoryIdArray = $queryBuilder->pluck('category_id')->toArray();
        return $categoryIdArray;
    }
}
