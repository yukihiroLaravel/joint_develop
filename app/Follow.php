<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    public function followUser()
    {
        return $this->belongsTo(User::class);
    }

    public function followerUser()
    {
        return $this->belongsTo(User::class);
    }
}
