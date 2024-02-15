<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function follow($id)
    {
        \Auth::user()->follow($id);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function unfollow($id)
    {
        \Auth::user()->unfollow($id);
        return back();
    }
}
