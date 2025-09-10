<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class TagController extends Controller
{
    public function show(Request $request, Tag $tag)
    {
        $query = $tag->posts()->with(['user', 'images'])->latest();

        // キーワード検索を追加
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where('content', 'like', '%' . $keyword . '%');
        }

        $posts = $query->paginate(10);

        return view('tags.show', [
            'tag' => $tag,
            'posts' => $posts,
            'keyword' => $request->input('keyword'),
        ]);
    }
}
