<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;

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
        $data=[
            'user' => $user,
        ];
        return view('users.show',$data);
    }
}
