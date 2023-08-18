<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Post;
use App\Http\Request\PostsRequest; 

class PostsController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function store(PostsRequest $request)
    {
        $post = new Post;
        $post->user_id = $request->user()->id;
        $post->text = $request->text;
        $post->save();
        return back();
    }
}
