<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    $post = Post::orderBy('id','desc')->paginate(10);
    return view('welcome', [
        'posts' => $posts,
    ]);
}
