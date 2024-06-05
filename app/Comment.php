<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    /*
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'content',
        'user_id',
        'post_id',
    ];
    //ユーザに対して所属する　一対多
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //投稿に対して所属する　一対多
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
