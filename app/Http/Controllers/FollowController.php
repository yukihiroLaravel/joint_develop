<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\User;

class FollowController extends Controller
{
    // タイムライン
    public function timeline($id)
    {
        $user = User::findOrFail($id);

        $ids = $user->followings()->pluck('users.id')->toArray();
        $ids[] = $user->id;
        $posts = Post::whereIn('user_id', $ids)->orderBy('id', 'desc')->paginate(9);

        return view('users.show', [
            'user'   => $user,
            'active' => 'timeline',
            'posts'  => $posts,
        ]);
    }

    // フォロー中一覧
    public function followings($id)
    {
        $user = User::findOrFail($id);

        return view('users.show', [
            'user'       => $user,
            'active'     => 'followings',
            'followings' => $user->followings,
        ]);
    }

    // フォロワー一覧
    public function followers($id)
    {
        $user = User::findOrFail($id);

        return view('users.show', [
            'user'      => $user,
            'active'    => 'followers',
            'followers' => $user->followers,
        ]);
    }
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
