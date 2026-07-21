<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'content',
        'image_path',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 投稿に対するリアクション一覧を取得
    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    // キーワード検索
    public function scopeSearch($query, $search)
    {
        if (!empty($search)) {
            $query->where('content', 'LIKE', '%' . $search . '%');
        }

        return $query;
    } 
       
    // 投稿に付いているタグを取得
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
}