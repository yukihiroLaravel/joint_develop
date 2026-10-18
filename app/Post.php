<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    // ユーザがリアクション済か判定
    public function isReactedBy($userId)
    {
        return $this->reactions->contains('user_id', $userId);
    }

    // タグの情報を取得
    public function tags()
    {
        return $this->belongsToMany('App\Tag'); 
    }

    // コメントの情報を取得 $post->comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // 最上位のコメント(投稿への直接のコメント)を取得 $post->topLevelComments
    public function topLevelComments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->oldest();
    }
}
