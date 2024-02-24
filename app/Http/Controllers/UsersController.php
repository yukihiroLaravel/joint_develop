<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;
use App\Post;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $data = [
            'user' => $user,
            'posts' => $posts,
        ];

	    return view('users.show', $data);
    } 

    public function edit($id)
    {
        $user = \Auth::user();

        if ($user->id != $id) {
            abort(404);
        }

        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, $id)
    {
        if (Auth::user()->id != $id) {
            abort(404);
        }

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return back();
        //return view('user.show', compact('user'));  //### ユーザ詳細が作成され次第、こちらに変更予定
    }
}
