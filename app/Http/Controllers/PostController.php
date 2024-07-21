<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
        ]);
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            return view('posts.edit',['post' => $post,]);
        }
        return back();
    }   
    
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id){
            $post->content = $request->content;
            $post->save();
            return redirect('/')->with('flashSuccess', '・投稿編集に成功しました。');
        } 
        return back();
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return back()->with('flashSuccess', '・投稿削除に成功しました。');
    }
    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();
        return back()->with('flashSuccess', '・投稿に成功しました。');
    }
}