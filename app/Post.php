<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'content', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 画像リレーション
    public function images()
    {
        return $this->hasMany(PostImage::class);
    }

    // 返信リレーション
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}