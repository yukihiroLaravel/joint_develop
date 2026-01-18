<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    // フォローする
    public function store($id)
    {
        $user = Auth::user();

        // 自分自身はフォローできない
        if ($user->id === (int) $id) {
        return back();
        }

        // すでにフォローしていなければフォロー
        if (! $user->isFollowing($id)) {
        $user->followings()->attach($id);
        }
        return back();
    }

    // フォロー解除
    public function destroy($id)
    {
        $user = Auth::user();
        if ($user->isFollowing($id)) {
        $user->followings()->detach($id);
        }
        return back();
    }
}