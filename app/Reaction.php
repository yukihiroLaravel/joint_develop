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

    const COLORS = [
        self::TYPE_RELATABLE => '#8edff2',
        self::TYPE_DONT_MIND => '#f7a8a8',
        self::TYPE_SAME => '#f4a261',
        self::TYPE_NICE_TRY => '#f6c453',
        self::TYPE_NEXT_TIME => '#7bcfa6',
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

    public function replies()
    {
        return $this->hasMany(ReactionReply::class);
    }
}
