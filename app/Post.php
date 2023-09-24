<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Databade\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
