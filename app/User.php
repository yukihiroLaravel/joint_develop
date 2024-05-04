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
    public function post()
    {
        return $this->hasMany(Post::class);
    }
    // フォロワー関連（他のユーザーにフォローされている）
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
    }
    // フォローしているユーザー関連（他のユーザーをフォローしている）
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }
    // ユーザーをフォロー
    public function follow(User $user)
    {
        // 既にフォローしているかどうかを確認
        if ($this->isFollowing($user)) {
            return false; // すでにフォローしているため、何もせずに false を返す
        } else {
            $this->following()->attach($user); // フォローしていない場合、フォローを実行
            return true; // フォロー成功
        }
    }
    // ユーザーのフォローを解除
    public function unfollow(User $user)
    {
        // ユーザーをフォローしているかどうかを確認
        if ($this->isFollowing($user)) {
            $this->following()->detach($user); // フォローしている場合、フォローを解除
            return true; // フォロー解除成功
        } else {
            return false; // フォローしていないため、何もせずに false を返す
        }
    }
    // 特定のユーザーをフォローしているかどうか確認
    public function isFollowing(User $user)
    {
        return $this->following()->where('followed_id', $user->id)->exists();
    }
}
