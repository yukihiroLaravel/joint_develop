<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
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

    public function storeComment($commentId)
    {
        \Auth::user()->favoriteComment($commentId);
        return back();
    }

    public function destroyComment($commentId)
    {
        \Auth::user()->unfavoriteComment($commentId);
        return back();
    }
}
