<?php

namespace App;

use Illuminate\Database\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostImage extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        "post_id","file_name","file_path","file_size"
    ];

    protected $dates = ['deleted_at']; 

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
