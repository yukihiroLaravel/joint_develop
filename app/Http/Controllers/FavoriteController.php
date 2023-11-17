<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store(Request $request, $id)
    {
        \Auth::user()->favorites($id);
        return back();
    }
    public function destroy($id)
    {
        \Auth::user()->unfavorites($id);
        return back();
    }
}
