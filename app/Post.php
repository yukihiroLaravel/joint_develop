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
        return $this->hasMany(PostImage::class)->whereNull('deleted_at');
    }
}