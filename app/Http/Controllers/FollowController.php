<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class FollowController extends Controller
{
    public function store($userId)
    {
        \Auth::user()->follow($userId);
        return back();
    }

    public function destroy($userId)
    {
        \Auth::user()->unfollow($userId);
        return back();
    }
}
