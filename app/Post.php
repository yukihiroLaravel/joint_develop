<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;   // 追記

use App\User;

class Post extends Model
{   
    use SoftDeletes;    // 追記
    // ユーザーメソッド追加
    public function user()
    {   
        return $this->belongsTo(User::class);
    }
}

