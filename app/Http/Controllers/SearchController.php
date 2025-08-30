<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $type = $request->input('type', 'posts'); // デフォルトは投稿検索

        $posts = collect();
        $users = collect();

        if ($type === 'posts') {
            // 投稿検索
            $posts = Post::with('user', 'images')
                ->when($keyword, function ($query, $keyword) {
                    $query->where('content', 'like', "%{$keyword}%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } elseif ($type === 'users') {
            // ユーザ検索
            $users = User::when($keyword, function ($query, $keyword) {
                    $query->where('name', 'like', "%{$keyword}%")
                          ->orWhere('email', 'like', "%{$keyword}%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            // 投稿はそのままの順序で取得
            $posts = Post::with('user', 'images')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('welcome', compact('posts', 'users', 'keyword', 'type'));
    }

}
