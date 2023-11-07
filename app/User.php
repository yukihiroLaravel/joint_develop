<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


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

    public function user()
    {
    return $this->belongsTo(User::class, 'user_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function followings()
    {
        // ユーザーがフォローしているユーザー一覧を取得
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follow_id')->withTimestamps();
    }
    
    public function followers()
    {
        // ユーザーをフォローしているユーザー一覧を取得
        return $this->belongsToMany(User::class, 'follows', 'follow_id', 'user_id')->withTimestamps();
    }
    
    public function follow($userId)
    {
        // 自分自身をフォローしようとしている場合はエラーとする
        if ($this->id === $userId) {
            return false;
        }
    
        // すでにフォローしているユーザーを再度フォローしようとしている場合もエラーとする
        if ($this->isFollow($userId)) {
            return false;
        }
    
        // フォローを実行
        $this->followings()->attach($userId);
        return true;
    }
    
    public function unFollow($userId)
    {
        // 自分自身をアンフォローしようとしている場合はエラーとする
        if ($this->id === $userId) {
            return false;
        }
    
        // まだフォローしていないユーザーをアンフォローしようとしている場合はエラーとする
        if (!$this->isFollow($userId)) {
            return false;
        }
    
        // アンフォローを実行
        $this->followings()->detach($userId);
        return true;
    }
    
    public function isFollow($userId)
    {
        // ユーザーが指定したユーザーをフォローしているかをチェック
        return $this->followings()->where('follow_id', $userId)->exists();
    }

    public static function boot(): void
    {
        parent::boot();
        static::deleted(function ($user) {
            $user->posts()->delete();
        });
    }
} 