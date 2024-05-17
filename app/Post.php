<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
        public function user() //Postモデルにuserメソッド定義
    {
        return $this->belongsTo(User::class); //リレーション定義 「1対多」の多側
    }

    public function favoriteUsers()
    {
        return $this->belongsToMany(User::class, 'favorites', 'post_id', 'user_id')->withTimestamps();
    }
}