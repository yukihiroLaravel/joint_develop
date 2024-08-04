<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes; // 追記

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes; // 追記

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

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'followed_user_id')->withTimestamps();
    }

    public function follow($userId)
    {
        $exist = $this->isFollowing($userId);
        if ($exist) {
            return false;
        } else {
            $this->following()->attach($userId);
            return true;
        }
    }

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

    public function isFollowing($userId)
    {
        return $this->following()->where('followed_user_id', $userId)->exists();
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {
            $user->posts()->delete();
        });
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'followed_user_id')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_user_id', 'user_id')->withTimestamps();
    }
}