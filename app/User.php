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

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {
            $user->posts()->delete();
        });
    }

    //多対多リレーション
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follow_user', 'user_id', 'follow_id')->withTimestamps();
    }

    //多対多リレーション逆
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follow_user', 'follow_id', 'user_id')->withTimestamps();
    }

    //フォローしているか判定
    public function isFollowing($postId)
    {
        return $this->followers()->where('follow_id', $postId)->exists();
    }

    //フォローする
    public function follow($postId)
    {
        $existing = $this->isFollowing($postId);
        $myself = $this->id == $postId;
        if (!$existing && !$myself) {
            $this->followers()->attach($postId);
        } else {
            return false;
        }
    }

    //フォロー解除する
    public function unfollow($postId)
    {
        $existing = $this->isFollowing($postId);
        $myself = $this->id == $postId;
        if ($existing && !$myself) {
            $this->followers()->detach($postId);
        } else {
            return false;
        }
    }

    //多対多リレーション。いいね
    public function favorites()
    {
        return $this->belongsToMany(Post::class, 'favorites', 'user_id', 'post_id')->withTimestamps();
    }

    //いいねしているか判定
    public function isFavorite($postId)
    {
        return $this->favorites()->where('post_id', $postId)->exists();
    }

    //いいねする
    public function favorite($postId)
    {
        $existing = $this->isFavorite($postId);
        if ($existing) {
            return false;
        } else {
            $this->favorites()->attach($postId);
        }
    }

    //いいね解除する
    public function unfavorite($postId)
    {
        $existing = $this->isFavorite($postId);
        if ($existing) {
            $this->favorites()->detach($postId);
        } else {
            return false;
        }
    }
    
}
