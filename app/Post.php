<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Postモデルにuserメソッド定義
    public function user()
    {
        // リレーションを定義 「1対多」の多側
        return $this->belongsTo(User::class);
    }

    public function favoriteUsers()
    {
        return $this->belongsToMany(User::class, 'favorites', 'post_id', 'user_id')->withTimestamps();
    }
}
