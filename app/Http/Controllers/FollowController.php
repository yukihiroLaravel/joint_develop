<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowController extends Controller
{
    //フォローする
    public function store($id)
    {
        \Auth::user()->follow($id);
        return back();
    }

    //フォローをやめる
    public function destroy($id)
    {
        \Auth::user()->unfollow($id);
        return back();
    }
}
