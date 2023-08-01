<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class UsersController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->paginate(9);
        return view('welcome', [
            'posts' => $posts,
        ]);
    }
}
