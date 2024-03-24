<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Hash; // クラスの外側で必要なクラスをインポート

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $data=[
            'user' => $user,
            'posts' => $posts,
        ];
        return view('users.show', $data);
    }

    public function edit($id)
    {
        if ($id == \Auth::id()) {
            $user = \Auth::user();
            return view('users.edit', ['user' => $user]);
        }
        abort(404);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return back();
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() == $user->id) {
            $user->delete();
        }
        return back();
    }

    public function following($id)
    {
        $user = User::findOrFail($id);
        $followings = $user->following()->get();
        $data = [
            'user' => $user,
            'followings' => $followings,
        ];
        return view('users.show',$data);
    }

    public function followed($id)
    {
        $user = User::findOrFail($id);
        $followers = $user->followed()->get();
        $data = [
            'user' => $user,
            'followers' => $followers,
        ];
        return view('users.show',$data);
    }
}

