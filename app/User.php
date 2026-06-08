<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;   // 追記
use App\Follow;//Followモデルをインポート
use Illuminate\Support\Facades\Auth; // Authファサードを読み込む

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;    // 追記

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

    // 投稿の取得
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // ユーザが削除されると投稿も削除される
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {
            $user->posts()->delete();
        });
    }

    // フォローしているユーザの取得
    public function followee()
    {
        return $this->belongsToMany(User::class, 'follows','following', 'followed')->withTimestamps();
    }

    // フォローされているユーザの取得
    public function follower()
    {
        return $this->belongsToMany(User::class, 'follows','followed','following')->withTimestamps();
    }

    // フォローしていなければフォローする
    public function following($id)
    {
        $exist = $this->isFollowing($id);
        if ($exist) {
            return false;
        } else {
            $this->followee()->attach($id);
            return true;
        }
    }
    // フォローしていればフォローを解除する
    public function unfollowing($id)
    {
        $exist = $this->isFollowing($id);
        if ($exist) {
            $this->follower()->detach($id);
            return true;
        } else {
            return false;
        }
    }
    // ログインユーザが対象ユーザをフォローしているか判定
    public function isFollowing($id)
    {
        return $this->followee()->where('following', Auth::id())->where('followed', $id);
    }

    // ログインユーザが対象ユーザにフォローされているか判定
    public function isFollowed($id)
    {
        return $this->follower()->where('followed', Auth::id())->where('following', $id);
    }

}
