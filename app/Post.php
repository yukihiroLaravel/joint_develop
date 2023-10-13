<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use SoftDeletes;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
