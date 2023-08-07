<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(9);
        return view('welcome', [
            'posts' => $posts,
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
        $data = [
            'user' => $user,
            'posts' => $posts
        ];
        return view('users.show',$data);
    }

    // public function edit($id)
    // {
    //     $user = User::findOrFail($id);
    //     $data=[
    //         'user' => $user,
    //     ];
    //     return view('users.edit', $data);
    // }
    
    public function edit($id)
    {
       if(\Auth::id() === ($id)){
            $user = \Auth::user();
            $data=[
                'user' => $user,
            ];
            return view('users.edit', $data);
        }else{
            return back();
        }
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return back();
    }
}
