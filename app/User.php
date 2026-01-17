<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Post;


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
    
    //多対多関係
    public function likes()
    {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id')->withTimestamps();
    }

    public function like($postId)
    {
        $exist = $this->isLike($postId);
        if ($exist) {
            return false;
        } else {
            $this->likes()->attach($postId);
            return true;
        }
    }

    public function unlike($postId)
    {
        $exist = $this->isLike($postId);
        if ($exist) {
            $this->likes()->detach($postId);
            return true;
        } else {
            return false;
        }

    }
    public function isLike($postId)
    {
        return $this->likes()->where('post_id', $postId)->exists();
    }

    // User が delete されたら自動で posts も delete する
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            $user->posts()->delete();

            // ▼ フォロー情報を論理削除（follows の deleted_at に値を入れる）
            \DB::table('follows')->where('follower_id', $user->id)->orWhere('followed_id', $user->id)->update(['deleted_at' => now()]);
        });
    }

    //フォローしているユーザー
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id')->withTimestamps();
    }
    //フォロワー
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id')->withTimestamps();
    }
}