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

    public function followers()
    {
        return $this->belongsToMany(User::class,'followers','following_user_id','followed_user_id')->withTimestamps();
    }

    public function follower($followerId) 
    {
        $exist = $this->isFollower($followerId);
        if ($exist) {
            return false;
        } else {
            $this->followers()->attach($followerId);
            return true;
        }
    }

    public function unfollower($followerId)
    {
        $exist = $this->isFollower($followerId);
        if ($exist) {
            $this->followers()->detach($followerId);
            return true;
        } else {
            return false;
        }
    }

    public function isFollower($followerId)
    {
        return $this->followers()->where('followed_user_id',$followerId)->exists();
    }

    public function followerUsers()
    {
        return $this->belongsToMany(User::class,'followers','following_user_id','followed_user_id')->withTimestamps();
    }

}
