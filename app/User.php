<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','profile',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 投稿
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // フォロー関連
    public function follows()
    {
        return $this->belongsToMany(User::class, 'follows','follow_id', 'followed_id')->withTimestamps();
    }
    
    public function follow($followedId)
    {
        $exist = $this->isFollow($followedId);
        
        if ($exist) {
            return false;
        } else {
            $this->follows()->attach($followedId);
            return true;
        }
    }

    public function unfollow($followedId)
    {
        $exist = $this->isFollow($followedId);
        
        if ($exist) {
            $this->follows()->detach($followedId);
            return true;
        } else {
            return false;
        }
    }

    public function isFollow($followedId)
    {
        return $this->follows()->where('followed_id', $followedId)->exists();
    }
        
    public function followed()
    {
        return $this->belongsToMany(User::class, 'follows','followed_id','follow_id')->withTimestamps();
    }

    // いいね関連
    public function favorites()
    {
        return $this->belongsToMany(Post::class, 'favorites', 'user_id', 'post_id')->withTimestamps();
    }

    // いいねをするメソッド
    public function favorite($postId)
    {
        $exist = $this->isFavorite($postId);
        
        if ($exist) {
            return false;
        } else {
            $this->favorites()->attach($postId);
            return true;
        }
    }

    // いいねを外すメソッド
    public function unfavorite($postId)
    {
        $exist = $this->isFavorite($postId);
        
        if ($exist) {
            $this->favorites()->detach($postId);
            return true;
        } else {
            return false;
        }
    }

    // すでにいいねしているか判定するメソッド
    public function isFavorite($postId)
    {
        // favoritesテーブルのpost_idカラムに引数の$postIdが存在するかどうかを検索(where)し真偽値で返す
        return $this->favorites()->where('post_id', $postId)->exists();
    }
}
