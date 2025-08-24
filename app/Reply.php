<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        'post_id', 'user_id', 'content',
    ];

    // 投稿に対するリレーション
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // ユーザーに対するリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}