<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use SoftDeletes;
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    protected $table = 'replys';
}
