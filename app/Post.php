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
        return $this->belongsTo(User::class);
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
        });
    }
    
}
