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
        'is_admin' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            $user->posts()->update([
                'deleted_reason' => Post::DELETED_REASON_ACCOUNT_WITHDRAWAL,
            ]);

            $user->posts()->delete();
        });
    }

    // ユーザーが投稿した投稿一覧を取得
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // ユーザーが行ったリアクション一覧を取得
    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    // ユーザーが投稿したリプライ一覧を取得
    public function reactionReplies()
    {
        return $this->hasMany(ReactionReply::class);
    }

    // 自分がフォローしているユーザー一覧を取得
    public function followings()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'follower_id',
            'followed_id'
        )->withTimestamps();
    }

    // 自分をフォローしているユーザー一覧を取得
    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'followed_id',
            'follower_id'
        )->withTimestamps();
    }

    // 指定ユーザーをフォロー
    public function follow($userId)
    {
        if ($this->id == $userId) {
            return false;
        }

        if ($this->isFollowing($userId)) {
            return false;
        }

        $this->followings()->attach($userId);

        return true;
    }

    // 指定ユーザーをフォロー済みか判定
    public function isFollowing($userId)
    {
        return $this->followings()
            ->where('followed_id', $userId)
            ->exists();
    }

    // 指定ユーザーのフォローを解除
    public function unfollow($userId)
    {
        if ($this->isFollowing($userId)) {
            $this->followings()->detach($userId);

            return true;
        }

        return false;
    }
}