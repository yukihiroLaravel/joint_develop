<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    // public function show() {
    //     $user = User::findOrFail($id);
    //     return view('users.show', compact('user'));
    // }

    public function edit() {
        $user = \Auth::user();
        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request) {
        // バリデーションルールを定義
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.\Auth::id(),
            'password' => 'nullable|string|min:8|confirmed',
        ];
    
        // バリデーションを実行
        $validatedData = $request->validate($rules);
    
        // ユーザー情報を更新
        $user = \Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();
    
        return view('users.detail');
    }
    
    public function delete(Request $request) {
        if (\Auth::check()) {
            $user = \Auth::user();
            $user->delete();
    
            \Auth::logout();
        }
    
        return redirect('/');
    }
    
}
