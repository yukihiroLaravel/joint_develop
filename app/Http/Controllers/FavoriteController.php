<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class FavoriteController extends Controller
{
    public function store($id)
    {
        \Auth::user()->favorite($id);
        session()->flash('flash_message', 'いいねしました！');
        return back();
    }

    public function destroy($id)
    {
        \Auth::user()->unfavorite($id);
        return back();
    }
}
