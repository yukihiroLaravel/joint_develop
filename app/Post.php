<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
    protected $fillable = [
        'content',
        'user_id',
        'image_path',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    
}
