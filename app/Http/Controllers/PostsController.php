<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;


class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->orderBy('created_at', 'desc')->paginate(5);
        return view('welcome', [
            'posts' => $posts
        ]);
    }
}
