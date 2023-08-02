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
        $posts = Post::orderBy('created_at','desc')->paginate(9);
        return view('welcome', [
            'posts' => $posts,
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
      //$authuser = \Auth::user();
      //$posts=$authuser->posts()->orderBy('created_at', 'desc')->paginate(9);
        $data=[
            'user' => $user,
          //'authuser' => $authuser,
          //'$posts' => $posts,
        ];
        return view('users.show',$data);
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $data=[
            'user' => $user,
        ];
        return view('users.edit', $data);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        return back();
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) 
        {
            $user->delete();
        }
        return back();
    }

}
