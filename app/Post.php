<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;  

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = ['content', 'user_id'];
    
    public function user()
    {
        // Userモデルとのリレーション
        return $this->belongsTo(User::class);
    }

    // Replyモデルとのリレーション
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
