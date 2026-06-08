<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use SoftDeletes; // 論理削除
}
