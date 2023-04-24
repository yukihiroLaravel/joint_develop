<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
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

    protected $dates = [
        'deleted_at'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function follows()
    {
        return $this->belongsToMany(User::class, 'follow_users', 'following_id', 'followed_id')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follow_users', 'followed_id', 'following_id')->withTimestamps();
    }

    public function follow($followedId)
    {
        $exist = $this->isFollow($followedId);
        if ($exist) {
            return false;
        } else {
            $this->follows()->attach($followedId);
            return true;
        }
    }

    public function unFollow($followedId)
    {
        $exist = $this->isFollow($followedId);
        if ($exist) {
            $this->follows()->detach($followedId);
            return true;
        } else {
            return false;
        }
    }

    public function isFollow($followedId)
    {
        return $this->follows()->where('followed_id', $followedId)->exists();
    }

    // ユーザ退会と同時にユーザが所有する投稿も削除する内容
    public static function boot()
    {
        parent::boot();

        static::deleted(function ($user) {
            $user->posts()->delete();
        });
    }
}
