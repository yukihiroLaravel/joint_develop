<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    public function followings()
    {
        return $this->belongsToMany(User::class,'follows', 'user_id', 'followed_user_id');
    }
    //followersは動作未確認です 
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_user_id', 'user_id')->withTimestamps();
    }

    public function follow($userId)
    {
        $exist = $this->isFollow($userId);
        $itsMe = $this->id === $userId;
        if ($exist || $itsMe) {
            return false;
        } else {
            $this->followings()->attach($userId);
            return true;
        }
    }

    public function unFollow($userId)
    {
        $exist = $this->isFollow($userId);
        $itsMe = $this->id === $userId;
        if ($itsMe) {
            return false;
        } elseif ($exist) {
            $this->followings()->detach($userId);
            return true;
        } else {
            return false;
        }
    }

    public function isFollow($userId)
    {
        return $this->followings()->where('followed_user_id', $userId)->exists();
    }
    
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            $user->posts()->delete();
        });
    }
}