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
        $posts = Post::orderBy('id','desc')->paginate(10);
        return view('welcome',[
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

    public function store(PostRequest $request) 
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        if ($request->hasFile('image')){
            $post->image_path = $request->file('image')->store('posts','public');
        }
        $post->save();
        return back()->with('flashSuccess','投稿しました');
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id){ 
            $post->content = $request->content;
            if ($request->hasFile('image')){
                $post->image_path = $request->file('image')->store('posts','public');
            }
            $post->save();
            return redirect('/')->with('flashSuccess','投稿を更新しました');
        } 
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        //フラッシュメッセージ
        return back()->with('flashSuccess', '投稿を削除しました');
    }
}
