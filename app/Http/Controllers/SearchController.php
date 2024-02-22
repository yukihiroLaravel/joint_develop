<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        if ($request->has('search_word')) {
            $search_word = $request->search_word;
            $query = Post::query();
            $spaceConversion = mb_convert_kana($search_word, 's');
            $wordArraysearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($wordArraysearched as $value) {
                $query->where('content', 'LIKE', '%' . $value . '%');
            }
            $posts = $query->orderBy('id', 'desc')->paginate(10);
            return view('welcome', [
                'posts' => $posts,
                'search_word' => $search_word,
            ]);
        } else {
            $posts = Post::orderBy('id', 'desc')->paginate(10);

            return view('welcome', [
                'posts' => $posts,
            ]);
        }
    }
}
