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
    /**
     * フォローしているユーザー
     */
    public function followings()
    {
        return $this->belongsToMany(User::class,'followers','user_id','follow_id')->withTimestamps();
    }

    /**
     * フォローされているユーザー
     */
    public function followers()
    {
        return $this->belongsToMany(User::class,'followers','follow_id','user_id')->withTimestamps();
    }

    /**
     * 指定ユーザーをフォローしているか判定
     */
    public function isFollowing($userId)
    {
        return $this->followings()->where('follow_id', $userId)->exists();
    }
}
