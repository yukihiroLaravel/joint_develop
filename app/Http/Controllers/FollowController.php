<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function store($followed_id)
    {
        if(\Auth::id() != $followed_id){
            \Auth::user()->follow($followed_id);
        };
        return back();
    }

    public function destroy($followed_id)
    {
        if(\Auth::id() != $followed_id){
            \Auth::user()->unfollow($followed_id);
        }
        return back();
    }
}
