<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    // ログイン
    public function login(Request $request) {
        $user = \Auth::user();
        return view('users.login', ['user' => $user]);
    }

    // Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    // Route::post('login', 'Auth\LoginController@login')->name('login.post');
    // Route::get('logout', 'Auth\LoginController@logout')->name('logout');
}
