<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowController extends Controller

{
    public function store($id)
    {
        \Auth::user()->follow($id);
        return back()->with('status', 'フォローしました');
    }

    public function destroy($id)
    {
        \Auth::user()->unfollow($id);
        return back()->with('status', 'アンフォローしました');
    }
}