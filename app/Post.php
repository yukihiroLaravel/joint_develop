<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //　追記
use App\Tag;
use App\User;

class Post extends Model
{
    use SoftDeletes; // 追記

    protected $fillable = [
        'content',
        'user_id',
        'image',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likeUsers()
    {
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id')->withTimestamps();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
}
