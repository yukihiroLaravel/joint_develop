<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    Public function user()
    {
        return $this->belongsTo(User::class);
    }

    Public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
