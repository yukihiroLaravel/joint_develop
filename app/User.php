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
    // ユーザーをフォローする機能
    public function follow($userId)
    {
        // 自分自身をフォローしようとした場合は処理を拒否
        if ($this->id == $userId) {
            return false;
        }

        // 対象ユーザーを取得し、既にフォローしているか確認
        $user = self::findOrFail($userId);
        if ($this->isFollowing($user)) {
            return false;
        }
        
        // 対象ユーザーをフォロー
        $this->following()->attach($user);
        return true;
    }

    // ユーザーのフォローを解除する機能
    public function unfollow($userId)
    {
        // 自分自身のアンフォローは拒否
        if ($this->id == $userId) {
            return false;
        }
        // 対象ユーザーを取得し、フォロー中か確認
        $user = self::findOrFail($userId);
        if ($this->isFollowing($user)) {
            // フォロー中なら解除
            $this->following()->detach($user);
            return true;
        }
        return false;
    }
    // 対象ユーザーをフォローしているか確認
    public function isFollowing($user)
    {
        return $this->following()->where('followed_id', $user->id)->exists();
    }
    // いいね機能 
    // UserモデルとPostモデルの間に「1対多」のリレーションシップを定義
    // hasManyメソッドを使用して、「1対多」
    public function posts()
    {
        return $this->hasMany(Post::class); 
    }
    // UserモデルとPostモデルの間に「多対多」のリレーションシップを定義
    public function favorites()
    {
        return $this->belongsToMany(Post::class, 'favorites', 'user_id', 'post_id')->withTimestamps();
    }
    // ユーザーが特定の投稿をお気に入りに追加
    public function favorite($postId)
    {
        $exist = $this->isFavorite($postId); // 投稿が既にお気に入りに追加されているかどうかを確認
        if ($exist) {
            return false;
        } else {
            $this->favorites()->attach($postId); // お気に入りに追加
            return true;
        }
    }
    // ユーザーが特定の投稿をお気に入りから削除
    public function unfavorite($postId)
    {
        $exist = $this->isFavorite($postId); //投稿が既にお気に入りに追加されているかどうかを確認
        if ($exist) {
            $this->favorites()->detach($postId); //既にお気に入りに追加されている場合は、お気に入りから削除
            return true;
        } else {
            return false;
        }
    }
    // 特定の投稿がユーザーのお気に入りに追加されているかどうかを確認
    public function isFavorite($postId)
    {
        return $this->favorites()->where('post_id', $postId)->exists();
    }
}
