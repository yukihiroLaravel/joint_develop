<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
    //protected $profile_image;
        
    
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

    //コメント（ボケ回答）と一対多の関係
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    //フォロー中の多対多　belongsToMany関数（相手のモデル, ‘中間テーブル名’, ‘自モデルの外部キー名’, ‘相手モデルの外部キー名’)
    public function followings()
    {
        return $this->belongsToMany(User::class,'follows', 'user_id', 'followed_user_id');
    }
    
    //フォロワーの多対多　belongsToMany関数（相手のモデル, ‘中間テーブル名’, ‘自モデルの外部キー名’, ‘相手モデルの外部キー名’)
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_user_id', 'user_id')->withTimestamps();
    }

    //フォローする
    public function follow($userId)
    {
        $exist = $this->isFollow($userId);
        $itsMe = $this->id === $userId;
        if ($exist || $itsMe) {
            return false;
        } else {
            $this->followings()->attach($userId);
            return true;
        }
    }

    //フォローを外す
    public function unFollow($userId)
    {
        $exist = $this->isFollow($userId);
        $itsMe = $this->id === $userId;
        if ($itsMe) {
            return false;
        } elseif ($exist) {
            $this->followings()->detach($userId);
            return true;
        } else {
            return false;
        }
    }

    //フォロー中か否か判定
    public function isFollow($userId)
    {
        return $this->followings()->where('followed_user_id', $userId)->exists();
    }
    
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            $user->posts()->delete();
        });
    }

    public function favorites()
    {
        return $this->belongsToMany(Post::class,'favorites','user_id','post_id')->withTimestamps();
    }
    public function isFavorite($postId)
    {
        return $this->favorites()->where('post_id', $postId)->exists();
    }

    // public function getProfileImageAttribute()
    // {
    //     return $this->profile_image ? asset('uploads/' . $this->id . '/' . $this->profile_image) : null;
    // }

    public function favorite($postId)
{
    $exist = $this->isFavorite($postId);
    $isOwner = $this->isPostOwner($postId);

    if ($exist || $isOwner) {
        return false;
    } else {
        $this->favorites()->attach($postId);
        return true;
    }
}

private function isPostOwner($postId)
{
    // ロジックを追加して、投稿の所有者であるかどうかを確認する
    // 例: 投稿モデルにユーザーIDが格納されている場合、ログインユーザーのIDと比較するなど
    // 以下は例として、$postIdに紐づく投稿の所有者がログインユーザーであるかを判定する仮想的なロジックです

    // ログインユーザーのIDを取得（例：$loggedInUserId）
    $loggedInUserId = auth()->id();

    // $postIdに紐づく投稿の所有者のIDを取得（例：$postOwnerId）
    $postOwnerId = Post::find($postId)->user_id;

    // ログインユーザーと投稿の所有者が一致するかを判定
    return $loggedInUserId === $postOwnerId;
}


    public function unfavorite($postId)
    {
        $exist = $this->isFavorite($postId);
        if ($exist) {
            $this->favorites()->detach($postId);
            return true;
        } else {
            return false;
        }
    }

}