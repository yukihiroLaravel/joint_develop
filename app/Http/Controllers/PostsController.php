<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller

{
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->paginate(10);
    
        return view('welcome', ['posts' => $posts]);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return back();
    }

    public function edit($id)
    {
        $user= new User();
        $user = \Auth::user();
        $post = Post::findOrFail($id); 
        if(\Auth::check() && \Auth::id() == $user->id){
            $data=[
                'user' => $user,
                'post' => $post,
            ];
            return view('posts.edit', $data);
        }else{
            abort(404);
        };

    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        if(\Auth::check() && \Auth::id() == $post->user_id){
            $post->text = $request->text;
            $post->save();
            $posts = Post::orderBy('created_at','desc')->paginate(10);
            $data =[
                'post'=> $post,
                'posts' => $posts,
            ];
            return view('welcome',$data);
        }else{
            abort(404);
        }
    }
}