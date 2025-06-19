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

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id')->withTimestamps();
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id')->withTimestamps();
    }
    
    public function follow($userId)
    {
        if ($this->id === $userId || $this->isFollowing($userId)) 
        {
            return false;
        }    
        $this->followings()->attach($userId);
        return true;
    }   

    public function unfollow($userId)
    {
        if ($this->isFollowing($userId))  
        {
            $this->followings()->detach($userId);
            return true;
        }
        return false;  
    }

    public function isFollowing($userId)
    {
        return $this->followings()->where('users.id', $userId)->exists();
    }

    public function userCounts()
    {
        $countFollowings = $this->followings()->count();
        $countFollowers = $this->followers()->count();

        return [
            'countFollowings' => $countFollowings,
            'countFollowers' => $countFollowers,
        ];
    }
}