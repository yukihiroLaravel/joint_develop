<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //追記


class Post extends Model
{
    use SoftDeletes;  //追記
    public function user()
    {
        return $this->belongsTo(User::class);  //追記
    }
}
