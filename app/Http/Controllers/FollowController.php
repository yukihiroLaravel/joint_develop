<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     *フォロー実行
     *@param int $id
     *@return back
     */
    public function store($id)
    {
        \Auth::user()->follow($id);
        return back();
    }

    /**
     *フォロー解除
     *@param int $id
     *@return view
     */
    public function destroy($id)
    {
        \Auth::user()->unfollow($id);
        return back();
    }
}
