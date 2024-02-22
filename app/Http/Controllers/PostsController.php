<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;


class PostsController extends Controller
{
    public function index()
   {
        $posts = $user->posts()->orderBy('created_at', 'desc')->paginate(10);
        return view('welcome', [
            'user' => $user,
            'posts' => $posts,
        ]);
   
    }

   public function show($id)
   {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('created_at', 'desc')->paginate(10);
        return view('user.show', [
            'user' => $user,
            'posts' => $posts,
        ]);
   }
}
