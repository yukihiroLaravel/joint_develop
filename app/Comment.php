<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    public function post()
    {
        return $this->belongsTo(post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoriteCommentUsers()
    {
        return $this->belongsToMany(User::class, 'favorites', 'favorite_comment_id', 'favorite_user_id')->withTimestamps();
    }
}
