<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    /*
    * The attributes that are mass assignable.
    *
    * @var array
    */

    protected $fillable = [
        'content'
    ];
    //ユーザーとのリレーション　ユーザに所属している　一対多
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //コメントとのリレーション　投稿に対して複数存在する　一対多
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
