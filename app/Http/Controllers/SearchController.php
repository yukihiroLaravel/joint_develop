<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;

class SearchController extends Controller
{
    // 投稿検索
    public function postsSearch(Request $request)
    {
        // 入力フォームから送信された検索クエリを取得
        $searchQuery = $request->input('searchQuery');

        // 検索クエリから投稿内容を検索
        $searchResults = Post::where('content', 'like', '%' . $searchQuery . '%')
                            ->orderBy('updated_at', 'desc')
                            ->paginate(10);

        return view('search.postsSearch', ['searchQuery' => $searchQuery, 'searchResults' => $searchResults]);
    }
}
