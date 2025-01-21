<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostEditRequest;
use App\Post;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('welcome', compact('posts'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if(\Auth::id() === $post->user_id){
            return view('posts.edit', compact('post'));
        }
        
        return back()->with('権限がありません🙅');
    }

    public function update(PostEditRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        if(\Auth::id() === $post->user_id){
            $post->content = $request->content;
            $post->save();
            return redirect()->route('home')->with('更新に成功しました✅');
        }

        return back()->with('権限がありません🙅');
    }
}