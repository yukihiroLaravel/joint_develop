<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //投稿の情報を取得
    public function posts()
    {
        return $this->belongsToMany('App\Post'); 
    }
}
