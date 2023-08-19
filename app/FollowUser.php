<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FollowUser extends Pivot
{
    protected $fillable = ['following_user_id', 'followed_user_id'];

    protected $table = 'follow_users';
}
