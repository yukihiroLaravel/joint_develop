<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class RankingController extends Controller
{
    public function likes()
    {
        $posts = Post::with(['user', 'tags'])->withCount('likeUsers')->orderBy('like_users_count', 'desc')->paginate(10);

        return view('rankings.likes', [
            'posts' => $posts,
            ]);

    }
}
