<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\FollowUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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

    public static function boot()
    {
        parent::boot();
        
        static::deleted(function ($user) {
            $user->posts()->delete();
        });
    }

    //user_idに該当するユーザーがフォローしているユーザー達の情報を全て取得する。
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follow_users', 'user_id', 'followed_id');
    }

    //followed_idに該当するユーザーをフォローしているユーザー達の情報を全て取得する。
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follow_users', 'followed_id', 'user_id');
    }

    /**
     * ユーザーをフォローする処理。
     * @param string $id
     */
    public function follow($id) {
        DB::BeginTransaction();
        if (Auth::id() !== (int)$id && !$this->followCheck($id)) {
            try {
                $this->followings()->attach($id);
                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                abort(500);
            }
            return;
        }
        abort(404);
    }

    /**
     * フォローを解除する処理。
     * @param string $id
     */
    public function unfollow($id) {
        if (Auth::id() !== (int)$id && $this->followCheck($id)) {
            try {
                $this->followings()->detach($id);
            } catch (\Throwable $e) {
                abort(500);
            }
            return;
        }
        abort(404);
    }

    /**
     * フォロー状態を確認する。
     * @param string $id
     * @return boolean
     */
    public function followCheck ($id) {
        return $this->followings()->where('followed_id', $id)->exists();
    }

    public function tweets() {
        return $this->belongsToMany(Post::class, 'favorites', 'user_id', 'post_id');
    }

    /**
     * いいねする。
     * @param string $id
     */
    public function like ($id) {
        $post = Post::find($id);
        DB::BeginTransaction();
        if (Auth::id() !== $post->User_id && !$this->likeCheck($id)) {
            try {
                $this->tweets()->attach($id);
                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                abort(500); 
            }
            return;
        }
        abort(404);
    }

    /**
     * いいねを解除する。
     * @param string $id
     */
    public function dislike ($id) {
        $post = Post::find($id);
        if (Auth::id() !== $post->user_id && $this->likeCheck($id)) {
            try {
                $this->tweets()->detach($id);
            } catch (\Throwable $e) {
                abort(500);
            }
            return;
        }
        abort(404);
    }

    /**
     * いいね状態を確認する。
     * @param string $id
     * @return boolean
     */
    public function likeCheck ($id) {
        return $this->tweets()->where('post_id', $id)->exists();
    }

}

