<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SearchController;
use App\Post;
use Illuminate\Http\Request;


class SearchController extends Controller
{

public function index(Request $request)
{
    $keyword = $request->input('keyword');

    // 投稿をページネーション付きで取得
    $posts = Post::where('content', 'like', '%' . $keyword . '%')
                 ->orWhere('content', 'like', '%' . $keyword . '%')
                 ->paginate(10); // 1ページに表示するアイテム数を指定

    // フィルタリングされた投稿の総数をカウント
    $totalPosts = Post::where('content', 'like', '%' . $keyword . '%')
                 ->orWhere('content', 'like', '%' . $keyword . '%')
                 ->count();

        if ($posts->isEmpty()) {
            // 検索結果が空の場合
            $message = "検索した記事は見つかりませんでした。　(ヾﾉ･ω･`)ﾅｲﾅｲ";
            return view('search-results', compact('message'));
        }

    return view('search-results', compact('posts', 'totalPosts'));
}

}










