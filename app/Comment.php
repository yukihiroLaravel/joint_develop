<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content',
        'post_id',
        'user_id',
        'parent_id',
    ];

    // 投稿の情報を取得 $comment->post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // ユーザの情報を取得 $comment->user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 親コメントの情報を取得 $comment->parent
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // 子コメントの情報を取得 $comment->children
    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id')->oldest();
    }

    public function reactions()
    {
        return $this->hasMany(CommentReaction::class);
    }

    // ユーザがリアクション済か判定
    public function isReactedBy($userId)
    {
        return $this->reactions->contains('user_id', $userId);
    }
}
