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

    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_user_id', 'followed_user_id')->withTimestamps();
    } 

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_user_id', 'following_user_id')->withTimestamps();
    }

    public function isFollows($userId)
    {   
        return $this->followings()->where('followed_user_id', $userId)->exists();
    }

    public function follow($userId)
    {
        $itsMe = $this->id == $userId;
        $exist = $this->isFollows($userId);

        if ($exist || $itsMe) {
            return false;
        } else {
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    public function unfollow($userId)
    {
        $itsMe = $this->id == $userId;
        $exist = $this->isFollows($userId);
        if ($exist || $itsMe ) {
            $this->followings()->detach($userId);
            return true;
        } else {
            return false;
        }
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public static function boot(): void
    {
        parent::boot();
        static::deleted(function ($user) {
            $user->posts()->delete();
        });
    }



}
