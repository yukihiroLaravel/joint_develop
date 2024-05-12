<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;

class UsersController extends Controller
{
    // ユーザ詳細
    // 特定のユーザーの詳細情報とそのユーザーの最新投稿をページネーション付きで取得
    public function show($id)
    {
        $user = User::findOrFail($id);
        // フォローしているユーザーのIDリストを取得
        $followingIds = $user->followings()->pluck('users.id')->toArray();
        $followingIds[] = $user->id; // 自分のIDをリストに追加

        // 自分とフォローしているユーザーの投稿を取得
        $posts = Post::whereIn('user_id', $followingIds)->latest()->paginate(10);

        return view('users.show', compact('user', 'posts'));
    }
    
    // ユーザがフォローしている他のユーザ一覧を表示
    public function followings($id)
    {
        $user = User::findOrFail($id);
        $followings = $user->followings()->orderBy('id', 'desc')->paginate(10);

        return view('users.followings', compact('user', 'followings'));
    }

    // フォロワー一覧を表示
    public function followers($id)
    {
        $user = User::findOrFail($id);
        $followers = $user->followers()->orderBy('id', 'desc')->paginate(10);

        return view('users.followers', compact('user', 'followers'));
    }
}
