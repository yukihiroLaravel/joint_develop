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

    public function followers() 
    {
        return $this->belongsToMany(User::class, 'followers', 'following_user_id', 'followed_user_id')->withTimestamps();
    }

    public function follow($userId) 
    {
        $exist = $this->isFollow($userId);
        if ($exist) {
            return false;
        } else {
            $this->followers()->attach($userId);
            return true;
        }
    }
    
    public function unFollow($userId) 
    {
        $exist = $this->isFollow($userId);
        if ($exist) {
            $this->followers()->detach($userId);
            return true;
        } else {
            return false;
        }
    }
    
    public function isFollow($userId) 
    {
        return $this->followers()->where('followed_user_id', $userId)->exists();
    }
}
