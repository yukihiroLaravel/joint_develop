<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reply extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'post_id', 'content',
    ];

    // Userモデルとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Postモデルとのリレーション
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
