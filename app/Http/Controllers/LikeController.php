<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{   
    /**
     * likeメソッドを呼び出す。
     * @param string $id
     */
    public function exeLike ($id) {
        $user = Auth::user();
        $user->like($id);
        return back();
    }

    /**
     * dislikeメソッドを呼び出す。
     * @param string $id
     */
    public function exeDislike ($id) {
        $user = Auth::user();
        $user->dislike($id);
        return back();
    }
}
