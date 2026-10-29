<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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
        return $this->hasMany(Post::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            // ① 自分の投稿に付いたいいね！を削除(論理削除済みの投稿も含める)
            DB::table('likes')
                ->whereIn('post_id', $user->posts()->withTrashed()->pluck('id'))
                ->delete();
            // ② 自分が付けたいいね！を削除
            DB::table('likes')->where('user_id', $user->id)->delete();

            // ユーザ退会時に、そのユーザの投稿も削除する
            $user->posts()->delete();
            $user->followings()->detach(); // 自分がフォローしているユーザとの関係を削除
            $user->followers()->detach(); // 自分をフォローしているユーザとの関係を削除
        });
    }

    // フォロー中のユーザ
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id')->withTimestamps();
    }

    // フォロワー
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id')->withTimestamps();
    }

    public function follow($userId)
    {
        // 自分自身はフォロー出来ない
        if ($this->id == $userId) {
            return false;
        }
        // すでにフォロー中なら何もしない
        if ($this->isFollowing($userId)) {
            return false;
        }
        $this->followings()->attach($userId);
        return true;
    }

    public function unfollow($userId)
    {
        if (! $this->isFollowing($userId)) {
            return false;
        }
        $this->followings()->detach($userId);
        return true;
    }

    // フォロー中かどうか判定
    public function isFollowing($userId)
    {
        return $this->followings()->where('followed_id', $userId)->exists();
    }

    // いいね！した投稿
    public function likes()
    {
        return $this->belongsToMany(Post::class, 'likes')->withTimestamps();
    }
}