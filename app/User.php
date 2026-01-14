<?php

namespace App;

use App\Post;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
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


    protected static function boot() //laravelバージョン古いためbooted()関数が使えない
    {
        parent::boot(); //boot()使用する際必修
        static::deleting(function ($user) {
            // ユーザーが削除される時、その人の投稿も削除（論理削除）する
            \Log::info('Userを削除します。ID: ' . $user->id);
            $user->posts()->delete();
            \Log::info('紐づくPostの削除命令を送りました。');
        });
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    /**
     * フォローしているユーザー
     */
    public function followings()
    {
        return $this->belongsToMany(User::class,'followers','user_id','follow_id');
    }

    /**
     * フォローされているユーザー
     */
    public function followers()
    {
        return $this->belongsToMany(User::class,'followers','follow_id','user_id');
    }

    /**
     * 指定ユーザーをフォローしているか判定
     */
    public function isFollowing($userId)
    {
        return $this->followings()->where('follow_id', $userId)->exists();
    }
}
