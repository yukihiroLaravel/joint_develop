<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Tag;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $type = $request->input('type', 'posts'); // デフォルトは投稿検索

        $posts = collect();
        $users = collect();
        $tags = collect();

        if ($type === 'posts') {
            // 投稿検索
            $posts = Post::with('user', 'images')
                ->when($keyword, function ($query, $keyword) {
                    $query->where('content', 'like', "%{$keyword}%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            return view('welcome', compact('posts', 'users', 'tags', 'keyword'));
        }
        
        if ($type === 'users') {
        // ユーザ検索
            $users = User::when($keyword, function ($query, $keyword) {
                        $query->where('name', 'like', "%{$keyword}%")
                                ->orWhere('email', 'like', "%{$keyword}%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            return view('welcome', compact('posts', 'users', 'tags', 'keyword',));
        }

        if ($type === 'tags') {
            // タグ検索
            $tags = Tag::when($keyword, function ($query, $keyword) {
                        $query->where('name', 'like', "%{$keyword}%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            return view('welcome', compact('posts', 'users', 'tags', 'keyword',));
        }
    }

}
