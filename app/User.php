<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\FollowUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
     * @return view
     */
    public function follow($id) {
        DB::BeginTransaction();
        try {
            $this->followings()->attach($id);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            abort(500);
        }
    }

    /**
     * フォローを解除する処理。
     * @param string $id
     * @return view
     */
    public function unfollow($id) {
        try {
            $this->followings()->detach($id);
        } catch (\Throwable $e) {
            abort(500);
        }
    }

    /**
     * フォロー状態を確認する。
     * @param string $id
     * @return view
     */
    public function followCheck ($id) {
        $user = User::find($id);
        return $user->followers()->where('user_id', Auth::id())->exists();
    }
}
