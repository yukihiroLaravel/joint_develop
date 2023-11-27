<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
        $data=[
            'user' => $user,
            'posts' => $posts,
        ];
       return view('users.show' ,$data);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            return view("users.edit",["user" => $user]);
        }
        else {
            return back();
        }
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if (\Auth::id() === $user->id) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return back();
    }

    public function destroy($id)
    {

        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            $user->delete();
        }
            return back();
        
    }
    
    public function followings($id)
    {
        $user = User::findOrFail($id);
        $followings = $user->followings()->orderBy('id', 'desc')->paginate(9);
        $data=[
            'user' => $user,
            'followings' => $followings,
        ];
       return view('follow.followings' ,$data);
    }

    public function followers($id)
    {
        $user = User::findOrFail($id);
        $followers = $user->followers()->orderBy('id', 'desc')->paginate(9);
        $data=[
            'user' => $user,
            'followers' => $followers,
        ];
       return view('follow.followers' ,$data);
    }


}
