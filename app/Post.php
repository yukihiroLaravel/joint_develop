<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'content',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function favoriteUsers()
    {
        return $this->belongsToMany(User::class, 'favorites', 'post_id', 'user_id')->withTimestamps();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
    
    protected static function boot()
    {
        parent::boot(); // 親クラスのbootを呼び出す
        static::deleting(function ($post) {
            // Postが削除（論理削除を含む）されたときに実行される
            // 中間テーブルの紐付けを解除する
            $post->tags()->detach();
            // 子リプライを確実に連鎖削除
            foreach ($post->replies as $reply) {
                $reply->delete();
            }
        });
    }

    public function replies()
    {
        return $this->hasMany(Post::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Post::class, 'parent_id');
    }
}
