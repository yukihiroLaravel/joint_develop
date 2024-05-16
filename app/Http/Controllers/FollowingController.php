<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowingController extends Controller
{
    public function store($id)
    {
        \Auth::user()->follow($id);
        session()->flash('flash_message', 'フォローしました！');
        return back();
    }
    public function destroy($id)
    {
        \Auth::user()->unfollow($id);
        return back();
    }
}
