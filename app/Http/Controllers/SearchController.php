<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        if ($request->has('searchWords')) {
            $searchWords = mb_convert_kana($request->searchWords, 's');
            $arraySearchWords = preg_split('/[\s,]+/', $searchWords, -1, PREG_SPLIT_NO_EMPTY);
            $query = Post::query();
            foreach ($arraySearchWords as $searchWord) {
                $query->orwhere('content', 'LIKE', '%' . $searchWord . '%');
            }
            $posts = $query->orderBy('id', 'desc')->paginate(10);
            return view('welcome', [
                'posts' => $posts,
                'searchWords' => $searchWords,
                'arraySearchWords' => $arraySearchWords,
            ]);
        } else {
            $posts = Post::orderBy('id', 'desc')->paginate(10);

            return view('welcome', [
                'posts' => $posts,
            ]);
        }
    }
}
