<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Posts;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
  public function index()
  {

    $test = 1;
    dd($test);
    $user = User::all();
    dd($user);
    $posts = Posts::orderBy('id', 'desc')->paginate(10);

    return view('welcome', [
      'user' => $user,
      'posts' => $posts
    ]);
  }

  public function store(PostRequest $request)
  {
    $post = new Posts;
    $post->user_id = \Auth::id();
    $post->content = $request->content;
    $post->save();
    return back();
  }
}
