<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts.post', compact('posts'));
    }
}
