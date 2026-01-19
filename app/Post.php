<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $table = 'posts';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'content',
        'image_path',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
