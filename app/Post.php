<?php

//namespace App\Post; // ディレクトリ構造に合わせて修正
namespace App; //通常、Laravelのデフォルトのディレクトリ構造では、app ディレクトリ以下の名前空間は App から始まります。そのため、App\Post\Post クラスの名前空間も App から始める必要があります。

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    protected $fillable = ['content', 'user_id'];

    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
