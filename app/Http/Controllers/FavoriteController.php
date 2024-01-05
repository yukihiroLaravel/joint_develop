<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store(Request $request, $id)
    {
        \Auth::user()->favorite($id);
        return back()->with('status', 'イイね、しました');
    }
    public function destroy($id)
    {
        \Auth::user()->unfavorite($id);
        return back()->with('status', 'イイね、外しました');
    }
}
