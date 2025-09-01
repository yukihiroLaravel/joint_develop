<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

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

    // ユーザが削除されたときに、そのユーザの投稿も削除する
    public static function boot()
    {
        parent::boot();

        static::deleted(function ($user) {
            $user->posts()->delete();
        });
    }

    public function followings()
    // ユーザがフォローしているユーザを取得
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'followed_user_id')->withTimestamps();
    }

    public function followers()
    // ユーザをフォローしているユーザを取得
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_user_id', 'user_id')->withTimestamps();
    }

    public function isFollowing($userId): bool
    // ユーザが特定のユーザをフォローしているか確認
    {
        return $this->followings()->where('followed_user_id', $userId)->exists();
    }

    public function follow($userId)
    // ユーザをフォローする
    {
        $exist = $this->isFollowing($userId);
        if ($exist) {
            return false;
        } else {
            $this->followings()->attach($userId);
            return true;
        }
    }

    public function unfollow($userId)
    // ユーザのフォローを解除する
    {
        $exist = $this->isFollowing($userId);
        if ($exist) {
            $this->followings()->detach($userId);
            return true;
        } else {
            return false;
        }
    }

    public function favorites()
    {
        return $this->belongsToMany(Post::class, 'favorites', 'user_id', 'post_id')->withTimestamps();
    }    

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
    
    public function isFavorite($postId)
    {
        return $this->favorites()->where('post_id', $postId)->exists();
    }
}
