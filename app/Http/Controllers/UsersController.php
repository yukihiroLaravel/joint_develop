<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;

class UsersController extends Controller
{
    public function index()
    {
        $user = User::all();
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        
        return view('welcome', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts();
        $data = [
            'user'=> $user,
            'posts'=>$posts
        ];
        return view('users.show', $data);
    }

}
