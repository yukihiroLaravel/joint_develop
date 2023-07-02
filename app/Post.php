<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

    use SoftDeletes;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favoritePostUsers()
    {
        return $this->belongsToMany(User::class, 'favorites', 'favorite_post_id', 'favorite_user_id')->withTimestamps();
    }
}
