<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\SoftDeletes;
=======
use Illuminate\Database\Eloquent\SoftDeletes; // 追記
>>>>>>> 301d37908ca4d4a9e480f54ec8d89cfddb98938b

class User extends Authenticatable
{
    use Notifiable;
<<<<<<< HEAD
    use SoftDeletes;
=======
    use SoftDeletes; // 追記
>>>>>>> 301d37908ca4d4a9e480f54ec8d89cfddb98938b

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
}
