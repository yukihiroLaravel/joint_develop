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
        $posts = Post::orderBy('updated_at', 'desc')->paginate(4);
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
        $posts = $user->posts()->orderBy('updated_at', 'desc')->get();
        $data = ['user' => $user, 'posts' => $posts];
        return view('users.show', $data);
    }

    // Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    // Route::post('login', 'Auth\LoginController@login')->name('login.post');
    // Route::get('logout', 'Auth\LoginController@logout')->name('logout');
}
