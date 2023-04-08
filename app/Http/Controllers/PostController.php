<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;

class PostController extends Controller
{
    public function index()
    {
        $posts = Posts::orderBy('id','desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
        ]);
    }
}
