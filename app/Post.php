<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //追記
use App\Comment;


class Post extends Model
{
    use SoftDeletes;  //追記

    public function user()
    {
        return $this->belongsTo(User::class);  //追記
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($post) {
            $post->comments()->delete(); // 投稿に紐づくコメントを削除する
        });
    }
    
    public function favoriteUsers()
    {
        return $this->belongsToMany(User::class, 'favorites', 'post_id', 'user_id')->withTimestamps();
    }
}