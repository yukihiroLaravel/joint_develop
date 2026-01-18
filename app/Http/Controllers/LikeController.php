<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store($id)
    {
        \Auth::user()->like($id);
        return back();
    }

    public function destroy($id)
    {
        \Auth::user()->unlike($id);
        return back();
    }
}
