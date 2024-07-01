<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\post;

class PostsController extends Controller
{
    public function index()
    {

        $posts = post::orderBy('created_at','desc')->paginate(10);

        return view('welcome',[
            'posts' => $posts,
        ]);
        
    }
}
