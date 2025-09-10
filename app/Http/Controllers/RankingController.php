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

        return view('ranking.index', compact('posts'));
    }
}
