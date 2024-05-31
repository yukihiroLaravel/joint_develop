<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $posts = Post::where('content', 'like', '%' . $keyword . '%');
        $totalPosts = $posts->count();
        $posts = $posts->paginate(10);

        if ($posts->isEmpty()) {
            // 検索結果が空の場合
            $message = "検索した記事は見つかりませんでした。　(ヾﾉ･ω･`)ﾅｲﾅｲ";
            return view('search-results', [
                'message' => $message,
            ]);
        }

        return view('search-results', [
            'posts' => $posts,
            'totalPosts' => $totalPosts,
        ]);
    }
}
