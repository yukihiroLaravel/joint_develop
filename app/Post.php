<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Illuminate\App\Use;

class Post extends Model
{
    use SoftDeletes;
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // $value は makeLink メソッドの引数で使われている。このメソッド内でのみ動作。
    public function makeLink($value) {
        $pattern = '/(https?:\/\/[^\s]+)/';
        $replacement = '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a> ';
        return preg_replace($pattern, $replacement, $value);
    }
}
