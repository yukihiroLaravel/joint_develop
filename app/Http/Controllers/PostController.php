<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;
use App\User;
use App\Http\Requests\PostRequest;
class PostController extends Controller
{
    public function index()
    {
        $posts = Posts::orderBy('id','desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
        ]);
    }
    public function store(PostRequest $request)
    {
        $post = new Posts;
        $post->text = $request->contents;
        $post->user_id = $request->user()->id;
        $post->save();
        return back();
    }
}
