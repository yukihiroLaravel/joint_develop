<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes; //laravelに備え付けの論理削除を使えるようにする記述

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes; //クラス内で呼び出す宣言

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

    // リレーション定義 「1対多」の1側
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // フォロワー関連（他のユーザにフォローされている）
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
    }

    // フォローしているユーザ関連（他のユーザをフォローしている）
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }

    // ユーザIDを用いてユーザをフォロー
    public function follow($userId)
    {
        // 自分自身をフォローしようとした場合や既にフォローしている場合は何もしない
        if ($this->id == $userId || $this->isFollowing($userId)) {
            return false;
        }
        // 対象ユーザをフォロー
        $this->followings()->attach($userId);
        return true;
    }

    // ユーザIDを用いてフォローを解除
    public function unfollow($userId)
    {
        // 自分自身のアンフォローは拒否し、フォローしていない場合も何もしない
        if ($this->id == $userId || !$this->isFollowing($userId)) {
            return false;
        }
        // フォロー中なら解除
        $this->followings()->detach($userId);
        return true;
    }

    // 指定されたユーザIDがフォローされているかを確認
    public function isFollowing($userId)
    {
        return $this->followings()->where('followed_id', $userId)->exists();
    }
}
