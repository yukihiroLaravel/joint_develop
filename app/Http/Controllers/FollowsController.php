<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class FollowsController extends Controller
{
    public function store($id)
    {
        Auth::user()->follow($id);

        return back()->with('flash_message', 'フォローしました！');
    }

    public function destroy($id)
    {
        Auth::user()->unfollow($id);

        return back()->with('flash_message', 'フォローを解除しました。');
    }
}
