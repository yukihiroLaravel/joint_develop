<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Post extends Model
{
    use softDeletes;

    // リレーションメソッド
    public function user()
    {
        return $this->belongsTo(User::class);
    }
   


    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
