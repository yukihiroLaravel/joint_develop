<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Http\Requests\PostRequest;

use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
  public function index()
  {
    $posts = Post::orderBy('id', 'desc')->paginate(10);
    return view('welcome', ['posts' => $posts,]);
  }

  public function store(PostRequest $request)
  {
    $user = Auth::user();

    $post = new Post;
    $post->user_id = $user->id;
    $post->content = $request->content;
    $post->save();

    return back();
  }
}
