<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\PostRequest;
use App\User;

class PostsController extends Controller
{
    public function show($id)
    {
        $post = Post::findOrFail($id);
        
        return view('posts.show', [
            'post' => $post,
        ]);
        abort(403);
    }
    
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            return view('posts.edit', [
                'post' => $post,
            ]);
        }
        abort(403);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();
        session()->flash('flash-message', '投稿を編集しました。');
        return redirect()->route('search.index');
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();

        session()->flash('flash-message', '投稿しました。');

        return back();
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
            if (\Auth::id() === $post->user_id) {
                $post->delete();
            }
        session()->flash('flash-message', '投稿を削除しました。');
        return back();
    }
}
