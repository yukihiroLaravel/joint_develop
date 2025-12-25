<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'content',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
