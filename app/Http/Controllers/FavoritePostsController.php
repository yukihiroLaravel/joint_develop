<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoritePostsController extends Controller
{
    public function store($postId)
    {
        \Auth::user()->favoritePost($postId);
        return back();
    }

    public function destroy($postId)
    {
        \Auth::user()->unfavoritePost($postId);
        return back();
    }
}
