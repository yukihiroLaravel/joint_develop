<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function exeLike ($id) {
        $user = Auth::user();
        $user->like($id);
        return back();
    }

    public function exeDislike ($id) {
        $user = Auth::user();
        $user->dislike($id);
        return back();
    }
}
