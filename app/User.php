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

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($user) {
            $user->posts()->delete();
        });
    }

    //このユーザがフォローしている人を取得
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follow_id')->withTimestamps();
    }

    //このユーザをフォローしている人を取得
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'follow_id', 'user_id')->withTimestamps();
    }

    //フォローを実行
    public function follow($userId)
    {
        $exist = $this->isFollow($userId);
        if ($exist) {
            return false;
        } else {
            $this->followings()->attach($userId);
            return true;
        }
    }

    //フォローを外す
    public function unfollow($userId)
    {
        $exist = $this->isFollow($userId);
        if ($exist) {
            $this->followings()->detach($userId);
            return true;
        } else {
            return false;
        }
    }

    //フォローがすでにされているか判定
    public function isFollow($userId)
    {
        return $this->followings()->where('follow_id', $userId)->exists();
    }
}