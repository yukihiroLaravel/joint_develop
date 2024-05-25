<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    public function user()
    {
        //一対多の宣言
        return $this->belongsTo(User::class);    
    }
}
