<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes; // 追記

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes; // 追記

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'profile_image',
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

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function boot()
    {
        parent::boot();
        static::deleted(function ($user) {
            $user->posts()->delete();
        });
    }

    // フォロー機能
    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_user_id', 'followed_user_id')->withTimestamps();
    }

    public function followed()
    {
        return $this->belongsToMany(User::class, 'followers', 'followed_user_id', 'following_user_id')->withTimestamps();
    }
    
    public function isFollow($userId)
    {
        return $this->following()->where('followed_user_id', $userId)->exists();
    }

    public function follow($userId)
    {
        $exist = $this->isFollow($userId);
        if ($exist) {
            return false;
        } else {
            $this->following()->attach($userId);
            return true;
        }
    } 

    public function unfollow($userId)
    {
        $exist = $this->isFollow($userId);
        if ($exist) {
            $this->following()->detach($userId);
            return true;
        } else {
            return false;
        }
    }

    // いいね機能
    public function favoritePosts()
    {
        return $this->belongsToMany(Post::class, 'favorites', 'favorite_user_id', 'favorite_post_id')->withTimestamps();
    }

    public function favoriteComments()
    {
        return $this->belongsToMany(Comment::class, 'favorites', 'favorite_user_id', 'favorite_comment_id')->withTimestamps();
    }

    public function favoritePost($postId)
    {
        $exist = $this->isFavoritePosts($postId);
        if ($exist) {
            return false;
        } else {
            $this->favoritePosts()->attach($postId);
            return true;
        }
    }

    public function unfavoritePost($postId)
    {
        $exist = $this->isFavoritePosts($postId);
        if ($exist) {
            $this->favoritePosts()->detach($postId);
            return true;
        } else {
            return false;
        }
    }

    public function isFavoritePosts($postId)
    {
        return $this->favoritePosts()->where('favorite_post_id', $postId)->exists();
    }

    public function favoriteComment($commentId)
    {
        $exist = $this->isFavoriteComments($commentId);
        if ($exist) {
            return false;
        } else {
            $this->favoriteComments()->attach($commentId);
            return true;
        }
    }

    public function unfavoriteComment($commentId)
    {
        $exist = $this->isFavoriteComments($commentId);
        if ($exist) {
            $this->favoriteComments()->detach($commentId);
            return true;
    
            return false;
        }
    }
    public function isFavoriteComments($commentId)
    {
        return $this->favoriteComments()->where('favorite_comment_id', $commentId)->exists();
    }
}
