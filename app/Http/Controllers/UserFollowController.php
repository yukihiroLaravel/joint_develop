<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;

class UserFollowController extends Controller
{
    // フォローする
    public function store($id)
    {
        // 存在しないユーザは404エラー
        User::findOrFail($id);

        Auth::user()->follow($id);

        return back();
    }

    // フォローを解除する
    public function destroy($id)
    {
        Auth::user()->unfollow($id);

        return back();
    }

    public function followings($id)
    {
        $user = User::findOrFail($id);
        $users = $user->followings()->paginate(10);

        return view('users.followings', [
            'user' => $user,
            'users' => $users,
            'followingIds' => $this->followingIds($users),
        ]);
    }

    public function followers($id)
    {
        $user = User::findOrFail($id);
        $users = $user->followers()->paginate(10);

        return view('users.followers', [
            'user' => $user,
            'users' => $users,
            'followingIds' => $this->followingIds($users),
        ]);
    }

    // 表示中のユーザのうち、ログインユーザがフォロー中のIDを1回のSQLで取得する
    private function followingIds($users)
    {
        if(! Auth::check()) {
            return [];
        }

        return Auth::user()->followings()
            ->whereIn('users.id', $users->pluck('id'))
            ->pluck('users.id')
            ->all();
    }
}
