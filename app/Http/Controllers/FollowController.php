<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Follow;//Followモデルをインポート
use App\User;//Userモデルをインポート
use Illuminate\Support\Facades\Auth; // Authファサードを読み込む

class FollowController extends Controller
{
    // フォロー
    public function store($id)
    {
        \Auth::user()->following($id);
        return back();
    }

    // フォロー解除
    public function destroy($id)
    {
        \Auth::user()->unfollowing($id);
        return back();
    }

}
