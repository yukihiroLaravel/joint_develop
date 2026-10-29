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

    // この投稿にいいね！したユーザ
    public function likedUsers()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    protected static function boot()
    {
        parent::boot();

        // 投稿削除時に、その投稿に付いたいいね!も削除する
        static::deleting(function ($post) {
            $post->likedUsers()->detach();
        });
    }
}