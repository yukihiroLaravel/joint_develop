<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;


class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
        $data = [
            'user' => $user,
            'posts' => $posts,
        ];
        
        return view('users.show',$data);
    }

    public function edit($id)
    {
        if ($id == \Auth::id()) {
            $user = \Auth::user();
            return view('users.edit', ['user' => $user]);
        } 
        abort(403, 'アクセス権がありません'); 
        
    }
    
    public function update(UserRequest $request, $id)
    {
        if ($id == \Auth::id()) {
            $user = \Auth::user();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect()->route('user.show', $user->id)->with('updateMessage', 'ユーザ情報を更新しました。');
        }
    }

    public function  followings($id)
    {
        $user = User::findOrFail($id);
        $followings = $user->followings()->orderBy('id', 'desc')->paginate(9);
        $data=[
            'user' => $user,
            'followings' => $followings,
        ];
        return view('users.show', $data);
    }

    public function  followers($id)
    {
        $user = User::findOrFail($id);
        $followers = $user->followers()->orderBy('id', 'desc')->paginate(9);
        $data=[
            'user' => $user,
            'followers' => $followers,
        ];
        return view('users.show', $data);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            $user->delete();
            return redirect('/')->with('deleteMessage', 'ユーザー情報を削除しました。');
        }
    }
}