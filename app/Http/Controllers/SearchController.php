<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class SearchController extends Controller
{
    public function index()
    {
        return view('search.index');
    }

    public function search(Request $request)
    {
        // フォームから送信された検索ワードを取得
        $param1 = $request->input('param1');
        $param2 = $request->input('param2');
        $param3 = $request->input('param3');
        $param4 = $request->input('param4');
        $query = Post::query();
        // 検索条件を作成
        if ($param1) {
            $query->where('content', 'LIKE', "%{$param1}%");
        }
        if ($param2) {
            $query->whereHas('user', function ($q) use ($param2) {
                $q->where('name', 'LIKE', "%{$param2}%");
            });
        }
        if ($param3) {
            $query->where('created_at', '>=', "{$param3}");
        }
        if ($param4) {
            $query->where('created_at', '<=', "{$param4}");
        }

        // 結果を取得
        $posts = $query->orderBy('id', 'desc')->paginate(10);
        // return view('welcome', compact('posts','param1','param2','param3','param4'));
        return view('welcome', ['posts' => $posts]);
    }
}
