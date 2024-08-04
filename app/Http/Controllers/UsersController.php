<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $post = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $data=[
            'user' => $user,
            'posts' => $post,
        ];
        return view('users.show',$data);
    }

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
        return back()->with('flashSuccess', 'ユーザ情報を更新しました。');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('/')->with('flashSuccess', '退会しました。');
    } 

    public function followings($id)
    {
        $user = User::findOrFail($id);
        $followings = $user->followings()->orderBy('id','desc')->paginate(10);
        $data = [
            'user' => $user,
            'followings' => $followings,
        ];
        return view('follow.followings' ,$data);
    }

    public function followers($id)
    {
        $user = User::findOrFail($id);
        $followers = $user->followers()->orderBy('id','desc')->paginate(10);
        $data = [
            'user' => $user,
            'followers' => $followers,
        ];
        return view('follow.followers' ,$data);
    }

}