<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReactionReply extends Model
{
    protected $fillable = [
        'reaction_id',
        'user_id',
        'content',
    ];

    public function reaction()
    {
        return $this->belongsTo(Reaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
