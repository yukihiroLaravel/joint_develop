<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes; // Laravelに備え付けの論理削除を使えるようにする記述

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes; // クラス内で呼び出す宣言

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

    // 退会ユーザ所有の投稿削除（ユーザデータ削除後に投稿データを削除）
    public static function boot()
    {
        parent::boot();

        static::deleted(function ($user) {
            $user->posts()->delete();
        });
    }

    // いいね機能
    public function favorites()
    {
        return $this->belongsToMany(Post::class, 'favorites', 'user_id', 'post_id')->withTimestamps();
    }

    // ユーザが特定の投稿をいいねに追加
    public function favorite($postId)
    {
        $post = Post::findOrFail($postId);

        // 投稿が自分のものであるかを確認
        if ($post->user_id == $this->id) {
            // 自分の投稿の場合、falseを返す
            return false;
        }

        // 投稿が既にいいねに追加されているかどうかを確認
        $exist = $this->isFavorite($postId);
        if ($exist) {
            return false;
        } else {
            // いいねに追加
            $this->favorites()->attach($postId);
            return true;
        }
    }

    // ユーザが特定の投稿をいいねから削除
    public function unfavorite($postId)
    {
        $post = Post::findOrFail($postId);

        // 投稿が自分のものであるかを確認
        if ($post->user_id == $this->id) {
            // 自分の投稿の場合、falseを返す
            return false;
        }

        // 投稿が既にいいねに追加されているかどうかを確認
        $exist = $this->isFavorite($postId);
        if ($exist) {
            // 既にいいねに追加されている場合は、いいねから削除
            $this->favorites()->detach($postId);
            return true;
        } else {
            return false;
        }
    }

    // 特定の投稿がユーザのいいねに追加されているかどうかを確認
    public function isFavorite($postId)
    {
        return $this->favorites()->where('post_id', $postId)->exists();
    }
}
