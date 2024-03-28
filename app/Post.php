<?php

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

    public function getContentWithLinkAttribute(): string
    {
        $pattern = '/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/';
        $replace = '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>';
        return preg_replace($pattern, $replace, $this->content);
    }
}
