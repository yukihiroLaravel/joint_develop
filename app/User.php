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

    public static function boot()
    {
        parent::boot();
        static::deleted(function ($user) {
            $user->posts()->delete();
        });
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_user_id', 'followed_user_id')->withTimestamps();
    }
    
    public function followed()
    {
        return $this->belongsToMany(User::class, 'followers', 'followed_user_id', 'following_user_id')->withTimestamps();
    }

    public function isFollow($followed_user_id)
    {
        return $this->following()->where('followed_user_id', $followed_user_id)->exists();
    }

    public function follow($followed_user_id)
    {
        $exist = $this->isFollow($followed_user_id);
        if ($exist) {
            return false;
        } else {
            $this->following()->attach($followed_user_id);
            return true;
        }
    } 

    public function unfollow($followed_user_id)
    {
        $exist = $this->isFollow($followed_user_id);
        if ($exist) {
            $this->following()->detach($followed_user_id);
            return true;
        } else {
            return false;
        }
    }
}

