<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;

class SearchController extends Controller
{
    // 投稿検索クエリ取得
    public function postsSearch(Request $request)
    {
        // 入力フォームから送信された検索クエリを取得
        $searchQuery = $request->input('searchQuery');

        return redirect()->route('search.results', ['searchQuery' => $searchQuery]);
    }

    // 投稿検索実行・検索結果表示
    public function postsSearchResults($searchQuery)
    {
        // 検索クエリから投稿内容を検索
        $searchResults = Post::where('content', 'like', '%' . $searchQuery . '%')
                            ->orderBy('updated_at', 'desc')
                            ->paginate(10);

        return view('search.postsSearch', ['searchQuery' => $searchQuery, 'searchResults' => $searchResults]);
    }
}
