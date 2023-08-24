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

    public function followUsers()
    {
        return $this->belongsToMany(User::class, 'follow_users', 'followed_user_id', 'following_user_id');
    }

    public function follows()
    {
        return $this->belongsToMany(User::class, 'follow_users', 'following_user_id', 'followed_user_id');
    }

    /**
     * ユーザーをフォローする処理。
     * @param string $id
     * @return view
     */
    public static function follow($id) {
        DB::BeginTransaction();
        try {
            $user = User::find($id);
            $user->followUsers()->attach([
                'following_user_id' => Auth::id(),
            ]);
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
    public static function unfollow($id) {
        try {
            $user = User::find($id);
            $user->followUsers()->detach();
        } catch (\Throwable $e) {
            abort(500);
        }
    }
}
