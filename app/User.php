<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

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
    
    // ここにメソッドやプロパティを追加

    // 追加：UserとPostのリレーション
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_user_id', 'followed_user_id')->withTimestamps();
    }

    public function followers() 
    {
        return $this->belongsToMany(User::class, 'followers', 'followed_user_id', 'following_user_id')->withTimestamps();
    }

    public function follow($user)
    {
        $exist = $this->isFollow($user);
        if ($exist) {
            return false;
        } else {
            $this->followings()->attach($user);
            return true;
        }
    }
    
    public function unFollow($user)
    {
        $exist = $this->isFollow($user);
        if ($exist) {
            $this->followings()->detach($user);
            return true;
        } else {
            return false;
        }
    }
    
    public function isFollow($user)
    {
        return $this->followings()->where('followed_user_id', $user)->exists();
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {
            $user->posts()->delete();
        });
    }
}
