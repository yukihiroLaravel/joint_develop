<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteCommentsController extends Controller
{
    public function store($commentId)
    {
        \Auth::user()->favoriteComment($commentId);
        return back();
    }

    public function destroy($commentId)
    {
        \Auth::user()->unfavoriteComment($commentId);
        return back();
    }
}
