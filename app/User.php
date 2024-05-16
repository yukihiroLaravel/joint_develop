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
        return $this->hasMany(Post::class)->orderBy('id', 'desc');
    }

    // フォローしているユーザーのリレーションを定義するメソッド
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'followed_user_id')->withTimestamps();
    }

    // 指定されたユーザーをフォローするメソッド
    public function follow($userId)
    {
        // フォローしているかどうかを確認する
        $exist = $this->isFollowing($userId);
        if ($exist) {
            return false;
        } else {
            $this->following()->attach($userId);
            return true;
        }
    }

    // 指定されたユーザーのフォローを解除するメソッド
    public function unfollow($userId)
    {
        $exist = $this->isFollowing($userId);
        if ($exist) {
            $this->following()->detach($userId);
            return true;
        } else {
            return false;
        }
    }

    // 指定されたユーザーをフォローしているかどうかを確認するメソッド
    public function isFollowing($userId)
    {
        return $this->following()->where('followed_user_id', $userId)->exists();
    }
    
    
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($user){
            $user->posts()->delete();
        });
    }
}