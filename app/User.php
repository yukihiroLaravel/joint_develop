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
        return $this->hasMany(Posts::class);
    }

    public function follows()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }

    public function follow($userid)
    {
        $exist = $this->isfollow($userid);
        if ($exist) {
            return false;
        } else {
            $this->follows()->attach($userid);
            return true;
        }
    }

    public function unfollow($userid)
    {
        $exist = $this->isfollow($userid);
        if ($exist) {
            $this->follows()->detach($userid);
            return true;
        } else {
            return false;
        }
    }
    
    public function isfollow($userid)
    {
        return $this->follows()->where('follow_id', $userid)->exists();
    }

}
