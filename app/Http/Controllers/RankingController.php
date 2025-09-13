<?php

namespace App\Http\Controllers;

use App\Post;

class RankingController extends Controller
{
    public function index()
    {
        $posts = Post::withCount('favoriteUsers')
            ->orderBy('favorite_users_count', 'desc')
            ->take(10)
            ->get();

        $rankedPosts = [];
        $currentRank = 0;        // 表示する順位
        $previousCount = null;   // 前のいいね数
        $position = 0;           // 今何件目か

        foreach ($posts as $post) {
            $position++; //順位候補を進める
            
            if ($post->favorite_users_count !== $previousCount) {
                // いいね数が違えば、新しい順位を設定
                $currentRank = $position;
            }
            
            // 順位をセットして配列に入れる
            $rankedPosts[] = [
                'rank' => $currentRank,
                'post' => $post,
            ];

            $previousCount = $post->favorite_users_count; 
        }

        return view('ranking.index', ['rankedPosts' => $rankedPosts]);
    }
}
