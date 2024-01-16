<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    //ユーザー詳細
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
        $data=[
            'user' => $user,
            'posts' => $posts,
        ];
        $data += $this->userCounts($user);
        return view('users.show',$data);
    }

    // ユーザ編集画面_表示
    public function edit($id)
    {
        $user = \Auth::user();
        if ($user->id == $id) {
            return view('users.edit', ['user'=> $user]);
        }
        abort(404);
    }

    // ユーザ更新
    protected function update(UserRequest $request)
    {
        $user = \Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('user.show', \Auth::id())->with('message','ユーザ情報を更新しました！');
    }

    //ユーザー退会
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            $user->delete();
        }
        return back();
    }

    //タイムライン上のフォローした人
    public function followings($id)
    {
        $user = User::findOrFail($id);
        $followings = $user->following()->paginate(9);
        $data=[
            'user' => $user,
            'followings' => $followings,
        ];
        return view('users.show', $data);
    }

    //タイムライン上のフォロワー
    public function followers($id)
    {
        $user = User::findOrFail($id);
        $followers = $user->follower()->paginate(9);
        $data=[
            'user' => $user,
            'followers' => $followers,
        ];
        return view('users.show', $data);
    }

    public function favorites($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->favorites()->paginate(9);
        $data = [
            'user'=>$user,
            'posts'=>$posts
        ];
        $data += $this->userCounts($user);
        return view('users.show',$data);
    }
}
