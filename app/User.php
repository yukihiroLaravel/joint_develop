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

    public function followers()
    {
        return $this->belongsToMany(User::class,'follows','follow_user_id','followed_user_id');
    }

    public function follow($followedUserId)
    {
        $exist = $this->isFollow($followedUserId);
        if ($exist) {
            return false;
        } else {
            $this->followers()->attach($followedUserId);
            return true;
        }
    }

    public function unfollow($followedUserId)
    {
        $exist = $this->isFollow($followedUserId);
        if ($exist) {
            $this->followers()->detach($followedUserId);
            return true;
        } else {
            return false;
        }
    }

    public function isFollow($followedUserId)
    {   
        return $this->followers()->where('followed_user_id', $followedUserId)->exists();
    }
    

    public static function boot()
    {
        parent::boot();   

        static::deleted(function ($user) {
            $user->posts()->delete();
        });
    }    
}

