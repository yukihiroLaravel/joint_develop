<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;

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
}
