<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 論理削除機能をインポート

class Post extends Model
{
    use SoftDeletes; // 論理削除を有効化

    /**
     * 一括代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'content',
    ];

    /**
     * この投稿を所有するユーザーを取得（リレーション）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}