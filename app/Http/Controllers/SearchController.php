<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class SearchController extends Controller
{
    public function showSearchForm()
    {
        return view('search.advanced_search');
    }

    public function search(Request $request)
    {
        // フォームから送信された検索ワードを取得
        $searchContent = $request->input('searchContent');
        $searchUserName = $request->input('searchUserName');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $query = Post::query();

        // 検索条件を作成
        if ($searchContent) {
            $searchContent = str_replace('　', ' ', $searchContent);
            $searchWords = explode(' ', $searchContent);
            foreach ($searchWords as $word){
                $query->where('content', 'LIKE', "%{$word}%");
            }
        }
        if ($searchUserName) {
            $query->whereHas('user', function ($q) use ($searchUserName) {
                $q->where('name', 'LIKE', "%{$searchUserName}%");
            });
        }
        if ($startDate) {
            $query->where('created_at', '>=', "{$startDate}");
        }
        if ($endDate) {
            $query->where('created_at', '<=', "{$endDate}");
        }

        // 結果を取得
        $posts = $query->orderBy('id', 'desc')->paginate(10);
        return view('welcome', compact('posts','searchContent'));
    }
}
