<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use SoftDeletes;

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ユーザが、投稿にレビューをしたことがあるかの確認
    public static function hasReviewed(User $user, Post $post)
    {
        return self::where([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ])->exists();
    }

    // レビュー件数
    public static function reviewCounts(Post $post)
    {
        $countReviews = self::where('post_id', $post->id)
                            ->whereNull('deleted_at')
                            ->count();
        return [
            'countReviews' => $countReviews,
        ];
    }

    // 最新レビュー
    public static function latestReview(Post $post)
    {
        return self::where('post_id', $post->id)
                    ->latest()
                    ->first();
    }

    // 評価の平均を丸めて返す
    public static function getRoundedAverageFromCollection($collection, $key)
    {
        $average = $collection->avg($key);
        return $average ? round($average, 1) : null;
    }

    // 投稿に対するレビュー評価の平均を計算
    public static function averageRatingsFromCollection($reviews)
    {
        $service = self::getRoundedAverageFromCollection($reviews, 'rating_service');
        $cost    = self::getRoundedAverageFromCollection($reviews, 'rating_cost');
        $quality = self::getRoundedAverageFromCollection($reviews, 'rating_quality');
        $values = collect([$service, $cost, $quality])->filter();
        $overall = $values->isNotEmpty() ? round($values->avg(), 1) : null;
        return [
            'service' => $service,
            'cost'    => $cost,
            'quality' => $quality,
            'overall' => $overall,
        ];
    }
}