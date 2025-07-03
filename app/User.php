<?php
namespace App;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Gravatar;

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

    public function favorites()
    {
        return $this->belongsToMany(Post::class, 'favorites', 'user_id', 'post_id')->withTimestamps();
    }

    public function favorite($postId)
    {
        $exist = $this->isFavorite($postId);
        if ($exist) {
            return false;
        } else {
            $this->favorites()->attach($postId);
            return true;
        }
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

    public function isFavorite($postId)
    {
        return $this->favorites()->where('post_id', $postId)->exists();
    }

    public function follows()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'followed_id')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'followed_id', 'user_id')->withTimestamps();
    }

    //　いいね 
    public function favoritesCount()
    { 
        return $this->posts()->withCount('favorites')->get()->sum('favorites_count');
    }

    public function follow($userId)
    {
        $exist = $this->isFollow($userId);
        if ($exist) {
            return false;
        } else {
            $this->follows()->attach($userId);
            return true;
        }
    }

    public function unfollow($userId)
    {
        $exist = $this->isFollow($userId);
        if ($exist) {
            $this->follows()->detach($userId);
            return true;
        } else {
            return false;
        }
    }

    public function isFollow($userId)
    {
        return $this->follows()->where('followed_id', $userId)->exists();
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($user){
            $user->posts()->delete();
        });
    }

    protected $dates = ['deleted_at'];
    
    public function getAvatarImageUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar); // アップロード画像がある場合
        } else {
            return Gravatar::src($this->email, 310);  // なければGravatar
        }
    }
}

    