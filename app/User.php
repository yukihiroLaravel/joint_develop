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

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {
            $user->posts()->delete();
        });
    }

    //多対多リレーション
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follow_user', 'user_id', 'follow_id')->withTimestamps();
    }
    //多対多リレーション逆
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follow_user', 'follow_id', 'user_id')->withTimestamps();
    }

    //フォローしているか判定
    public function isFollowing($userId)
    {
        return $this->followers()->where('follow_id', $userId)->exists();
    }

    //フォローする
    public function follow($userId)
    {
        $existing = $this->isFollowing($userId);
        $myself = $this->id == $userId;
        if (!$existing && !$myself) {
            $this->followers()->attach($userId);
        } else {
            return false;
        }
    }

    //フォロー解除する
    public function unfollow($userId)
    {
        $existing = $this->isFollowing($userId);
        $myself = $this->id == $userId;
        if ($existing && !$myself) {
            $this->followers()->detach($userId);
        } else {
            return false;
        }
    }
}
