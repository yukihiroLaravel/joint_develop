<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    protected $fillable = [
        'text'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoriteUsers()
    {
        return $this->belongsToMany(User::class,'favorites','post_id','user_id')->withTimestamps();
    }
    //コメント（ボケ回答）と一対多の関係
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


}
