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

    protected static function boot()
    {
        parent::boot();

        self::deleting(function ($user) {
            // フォロー情報の削除( 性能考慮で直接的な削除をする )
            // from_user_idで絞って削除
            \DB::table('follows')->where('from_user_id', $user->id)->delete();
            // to_user_idで絞って削除
            \DB::table('follows')->where('to_user_id', $user->id)->delete();

            // 紐づいてるpostsの削除
            $user->posts()->delete();
        });
    }

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

    /**
     * 「フォロー中」のUserのリストを取得
     */
    public function followings()
    {
        // 「$this」のUserが「フォロー中」のUserのリストを取得

        // belongsToMany(相手のモデル, ‘中間テーブル名’, ‘自モデルの外部キー名’, ‘相手モデルの外部キー名’)
        
        // 相手のモデル             - 相手もUser
        // 中間テーブル名           - follows
        // 自モデルの外部キー名     - from_user_id ( 自分「$this」が、フォローしている側だから )
        // 相手モデルの外部キー名   - to_user_id   上記と逆の項目を相手側として指定

        // 
        // ->withPivot('id')
        // ->orderBy('follows.id', 'desc')
        // followsのidの降順、つまり、フォロー関係が作られたのが新しい順で
        // 取得するために必要。
        //
        // ->withTimestamps()は、created_at、updated_atの設定を自動化させるため

        return $this->belongsToMany(User::class, 'follows', 'from_user_id', 'to_user_id')
                    ->withPivot('id')
                    ->orderBy('follows.id', 'desc')
                    ->withTimestamps();
    }

    /**
     * 「フォロワー」のUserのリストを取得
     */
    public function followers()
    {
        // 「$this」のUserの「フォロワー」のUserのリストを取得
        // 言い換えると、「$this」のUserが、フォローされている側となってるUserのリストを取得

        // belongsToMany(相手のモデル, ‘中間テーブル名’, ‘自モデルの外部キー名’, ‘相手モデルの外部キー名’)
        
        // 相手のモデル             - 相手もUser
        // 中間テーブル名           - follows
        // 自モデルの外部キー名     - to_user_id ( 自分「$this」が、フォローされている側だから )
        // 相手モデルの外部キー名   - from_user_id   上記と逆の項目を相手側として指定

        // 
        // ->withPivot('id')
        // ->orderBy('follows.id', 'desc')
        // followsのidの降順、つまり、フォロー関係が作られたのが新しい順で
        // 取得するために必要。
        //
        // ->withTimestamps()は、created_at、updated_atの設定を自動化させるため

        return $this->belongsToMany(User::class, 'follows', 'to_user_id', 'from_user_id')
                    ->withPivot('id')
                    ->orderBy('follows.id', 'desc')
                    ->withTimestamps();
    }

    /**
     * フォローする。
     */
    public function follow($other_user_id)
    {
        // 「$this」のUserが、$other_user_idのUserをフォローする。

        $exist = $this->isFollowings($other_user_id);
        if ($exist) {
            return false;
        } else {
            $this->followings()->attach($other_user_id);
            return true;
        }
    }

    /**
     * フォローを解除する。
     */
    public function unfollow($other_user_id)
    {
        // 「$this」のUserが、$other_user_idのUserをフォローを解除する。

        $exist = $this->isFollowings($other_user_id);
        if ($exist) {
            $this->followings()->detach($other_user_id);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 「フォロー中」かどうか
     */
    public function isFollowings($other_user_id)
    {
        // 「$this」のUserが「$other_user_id」のUserを「フォロー中」かどうか

        return $this->followings()->where('to_user_id', $other_user_id)->exists();
    }

    /**
     * 「フォロワー」かどうか
     */
    public function isFollowers($other_user_id)
    {
        // 「$other_user_id」のUserが「$this」のUserの「フォロワー」かどうか

        return $this->followers()->where('from_user_id', $other_user_id)->exists();
    }
}
