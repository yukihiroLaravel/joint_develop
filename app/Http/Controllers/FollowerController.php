<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function store($id)
    {
        \Auth::user()->follower($id);
        return back();
    }

    public function destroy($id)
    {
        \Auth::user()->unfollower($id);
        return back();
    }
}
