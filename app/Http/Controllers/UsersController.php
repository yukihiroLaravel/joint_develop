<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Post;

class UsersController extends Controller
{
    // トップページ一覧表示
    public function index() 
    {
        $posts = Post::orderBy('updated_at', 'desc')->paginate(5);
        return view('welcome', ['posts' => $posts]);
    }

    // ログイン
    public function login(Request $request) {
        $user = \Auth::user();
        return view('users.login', ['user' => $user]);
    }

    public function show($id)
    {
        $user = User::find($id);
        $posts = $user->posts()->orderBy('updated_at', 'desc')->paginate(5);
        $data = ['user' => $user, 'posts' => $posts];
        return view('users.show', $data);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $posts = $user->posts()->orderBy('updated_at', 'desc')->paginate(5);
        $data = ['user' => $user, 'posts' => $posts];

        return view('users.show', $data);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/');
    }
}
