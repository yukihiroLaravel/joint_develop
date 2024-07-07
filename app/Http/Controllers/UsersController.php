<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\PostRequest;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UsersController extends Controller
{
    //ユーザ編集画面・更新
    public function edit($id)
    {
        $user = User::findOrFail($id);
        if (Auth::user()->id !== $user->id) {
            abort(403);
        }
        return view('users.edit', ['user' => $user]);
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
}
