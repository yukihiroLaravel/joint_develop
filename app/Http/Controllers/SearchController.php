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

        $posts = Post::where('title', 'like', '%' . $keyword . '%')->get();

        return view('search-results', compact('posts'));
    }
}
