<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 論理削除機能をインポート

class Post extends Model
{
    use SoftDeletes; // 論理削除を有効化

    /**
     * この投稿を所有するユーザーを取得（リレーション）
     */

    protected $fillable = ['content'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}