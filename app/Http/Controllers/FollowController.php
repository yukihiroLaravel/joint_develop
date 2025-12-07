<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class FollowController extends Controller
{
    public function follow($id)
    {
        $user = User::findOrFail($id);
        $follower = \Auth::user();

        if ($follower->id === $user->id) {
            return back()->with('error', '自分をフォローすることはできません');
        }

        $follower->followings()->syncWithoutDetaching([$user->id]);

        return back()->with('success', 'フォローしました');
    }

    public function unfollow($id)
    {
        $user = User::findOrFail($id);
        $follower = \Auth::user();

        $follower->followings()->detach($user->id);

        return back()->with('success', 'フォローを解除しました');
    }
}
