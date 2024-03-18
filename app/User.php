<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

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
        'name', 'email', 'password',
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
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // ユーザー(follow_user_id)がフォローしているユーザ(followed_user_id)のデータを取得する
    public function followUsers()
    {
        return $this->belongsToMany(User::class, 'follows', 'follow_user_id', 'followed_user_id')->withTimestamps();
    }
    // フォロー
    public function followerUsers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_user_id', 'follow_user_id')->withTimestamps();
    }

    // ログインユーザーかどうか判定
    public function itsMe($id)
    {
        if (Auth::id() === $id) {
            return true;
        } else {
            return false;
        }
    }

    // フォローする
    public function follow($id)
    {
        $exist = $this->isFollow($id);
        if (!$this->itsMe($id) && $exist) {
            return false;
        } else {
            $this->followUsers()->attach($id);
            return true;
        }
    }
    // フォロー解除
    public function unfollow($id)
    {
        $exist = $this->isFollow($id);
        if (!$this->itsMe($id) && $exist) {
            $this->followUsers()->detach($id);
            return true;
        } else {
            return false;
        }
    }

    // ユーザーをフォローしているかどうか
    public function isFollow($id)
    {
        return $this->followUsers()->where('followed_user_id', $id)->exists();
    }

    
    public function favorites()
    {
        return $this->belongsToMany(Post::class, 'favorites', 'user_id', 'post_id')->withTimestamps();
    }
    public function favorite($postId)
    {
        $exist = $this->isFavorite($postId);
        if ($exist && Auth::id() === $post->user_id) {
            return false;
        } else {
            $this->favorites()->attach($postId);
            return true;
        }
    }
    public function unfavorite($postId)
    {
        $exist = $this->isFavorite($postId);
        if ($exist && Auth::id() === $post->user_id) {
            return false;
        } else {
            $this->favorites()->detach($postId);
            return true;
        }
    }   
    public function isFavorite($postId)
    {
        return $this->favorites()->where('post_id', $postId)->exists();
    }
    protected static function boot()
    {
        parent::boot();
        static::deleted(function ($user) {
            $user->posts()->delete();
        });
    }
    
}

