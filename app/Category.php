<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    public $timestamps = true;

    protected $fillable = ['order', 'name'];

    /**
     * カテゴリをorderの昇順で取得するクエリビルダを返すメソッド
     */
    public static function getAllCategoriesQuery()
    {
        return self::orderBy('order', 'asc');
    }

    /**
     * $postIdを指定して選択済のcategoriesのid、nameをorder順で取得する。
     */
    public static function getSelectedCategoriesByPostId($postId)
    {
        return self::join('category_post', 'categories.id', '=', 'category_post.category_id')
            ->where('category_post.post_id', $postId)
            ->orderBy('categories.order', 'asc')
            ->select('categories.id', 'categories.name')
            ->get();
    }
}
