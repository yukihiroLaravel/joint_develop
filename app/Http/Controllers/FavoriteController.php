<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    //いいねする
    public function store($id)
    {
        \Auth::user()->favorite($id);
        return back();
    }
    //いいねを外す
    public function destroy($id)
    {
        \Auth::user()->unfavorite($id);
        return back();
    }
}
