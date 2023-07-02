<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoritePostsController extends Controller
{
    public function storePost($postId)
    {
        \Auth::user()->favoritePost($postId);
        return back();
    }

    public function destroyPost($postId)
    {
        \Auth::user()->unfavoritePost($postId);
        return back();
    }
}
