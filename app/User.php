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

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($user) {
            $user->posts()->delete();
        });
    }

    // フォロワー一覧
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'following_id')->withTimestamps();
    }

    // フォロー中一覧
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'followed_id')->withTimestamps();
    }

    // フォローする
    public function follow($userId)
    {
        $exist = $this->isFollowing($userId);
        if ($exist) {
            return false; // フォロー中ならfalseを返す
        } else {
            $this->followings()->attach($userId);
            return true;
        }
    }

    // フォロー解除
    public function unfollow($userId)
    {
        $exist = $this->isFollowing($userId);
        if ($exist) {
            $this->followings()->detach($userId);
            return true;
        } else {
            return false; // フォロー中でなければfalseを返す
        }
    }

    // フォロー中か
    public function isFollowing($userId)
    {
        // return $this->followings()->where('following_id',$userId)->exists();
        return true;
    }
}
