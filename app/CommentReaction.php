<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentReaction extends Model
{
    protected $fillable = ['user_id', 'comment_id', 'type'];

    public function user()
    {
        return $this->belongsTo(User::class); //user_id
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class); //comment_id
    }
}
