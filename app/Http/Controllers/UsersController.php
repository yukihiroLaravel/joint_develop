<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $data = [
            'user' => $user,
            'posts' => $posts
        ];
        $data += $this->countUsers($user);
        return view('users.show', $data); 
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);  
        abort_unless($user->id === \Auth::id(), 403);
        return view('users.edit', ['user' => $user]);
    }

    public function update(UserRequest $request, $id)
    {
        $user =User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('user.show', $id);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index');
    }

    // 「フォロー中」タイムライン
    public function timelineFollowing($id)
    {
        $user = User::findOrFail($id);
        // フォローした人を取得
        $followingId = $user->follows()->pluck('follow_id');
        // フォローした人の投稿を取得
        $posts = Post::whereIn('user_id', $followingId)->orderBy('id', 'desc')->paginate(10);
        $data = [
            'user' => $user,
            'posts' => $posts,
        ];
        $data += $this->countUsers($user);
        return view('users.show', $data);
    }
    
    // 「フォロワー」タイムライン
    public function timelineFollowers($id)
    {
        $user = User::findOrFail($id);
        // フォロワーを取得
        $followerId = $user->followUsers()->pluck('user_id');
        // フォロワーの投稿を取得
        $posts = Post::whereIn('user_id', $followerId)->orderBy('id', 'desc')->paginate(10);  //最後はget(); の代わりにpaginate(10);
        $data = [
            'user' => $user,
            'posts' => $posts,
        ];
        $data += $this->countUsers($user);
        return view('users.show', $data);
    }

    // ユーザの投稿数・フォロー数・フォロワー数(３つのタブに共通させるべき内容なので分けて作っておく)
    public function countUsers($user)
    {
        $countPosts = $user->posts()->count();
        $countFollowing = $user->follows()->count();
        $countFollowers = $user->followUsers()->count();
        $data = [
            'countPosts' => $countPosts,
            'countFollowing' => $countFollowing,
            'countFollowers' => $countFollowers,
        ];
        return $data;
    }
}