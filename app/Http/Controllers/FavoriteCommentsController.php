<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteCommentsController extends Controller
{
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
