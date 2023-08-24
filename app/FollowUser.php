<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FollowUser extends Pivot
{
    protected $table = 'follow_users';
}
