<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowersController extends Controller
{
    public function store($id)
    {
        \Auth::user()->follow($id);
        return back()->with('greenMessage', 'フォローしました');
    }

    public function destroy($id)
    {
        \Auth::user()->unfollow($id);
        return back()->with('redMessage', 'フォロー解除しました');
    }
}
