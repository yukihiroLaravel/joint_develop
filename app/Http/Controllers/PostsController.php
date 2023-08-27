<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Post;
use App\Http\Request\PostsRequest; 

class PostsController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts->orderBy('id', 'desc')->paginate(10);
        $data=[
            'posts' => $posts,
        ];
        $data += $this->userCounts($user);
        return view('users.show',$data);
    }
    
    public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
        ]);
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
