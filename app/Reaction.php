<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    const TYPE_RELATABLE = 'relatable';
    const TYPE_DONT_MIND = 'dont_mind';
    const TYPE_SAME = 'same';
    const TYPE_NICE_TRY = 'nice_try';
    const TYPE_NEXT_TIME = 'next_time';

    const TYPES = [
        self::TYPE_RELATABLE => 'あるある',
        self::TYPE_DONT_MIND => 'ドンマイ',
        self::TYPE_SAME => '自分もやった',
        self::TYPE_NICE_TRY => 'ナイストライ',
        self::TYPE_NEXT_TIME => '次はいける',
    ];

    protected $fillable = [
        'post_id',
        'user_id',
        'reaction_type',
        'encouragement',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
