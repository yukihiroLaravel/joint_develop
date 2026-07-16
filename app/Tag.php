<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * このタグが付いている投稿を取得する。
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class)->withTimestamps();
    }
}
