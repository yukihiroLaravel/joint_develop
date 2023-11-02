<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);

        return view('welcome',[
            'posts' => $posts,
        ]);
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();
        return back();
    }

    public function destroy($id)
    {
        $posts = Post::findOrFail($id);
        if (\Auth::id() === $posts->user_id) {
           $posts->delete();
        }
        return back();
    } 

    public function edit($id)
     {
         $post = Post::findOrFail($id);
         if (\Auth::id() === $post->user_id) {
             $data = [
                 'post' => $post,
             ];
             return view('posts.edit', $data);
         } 
         return back();
     }
     
     public function update(PostRequest $request, $id)
     {
         $post = Post::findOrFail($id);
         $post->content = $request->content;
         $post->save();
         return redirect('/');
     }
} 
