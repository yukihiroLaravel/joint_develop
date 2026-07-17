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

    // フォローしているユーザー一覧を取得
    public function followings()
    {
        return $this->belongsToMany(User::class,'follows','following_id','followed_id')->withTimestamps();
    }

    // 自分をフォローしているユーザー一覧を取得
    public function followers()
    {
        return $this->belongsToMany(User::class,'follows','followed_id','following_id')->withTimestamps();
    }

    // ユーザーをフォローする(後ほどidを修正)
    public function follow($UserId)
    {
        $exist = $this->isFollowing($UserId);
        if ($exist) {
            return false;
        } else {
            $this->followings()->attach($UserId);
            return true;
        }
    }

    // ユーザーのフォローをはずす(後ほどidを修正)
    public function unfollow($UserId)
    {
        $exist = $this->isFollowing($UserId);
        if ($exist) {
            $this->followings()->detach($UserId);
            return true;
        } else {
            return false;
        }
    }

    // フォローの判定をしてくれる
    public function isFollowing($UserId)
    {
        return $this->followings()->where('users.id', $UserId)->exists();
    }
}
