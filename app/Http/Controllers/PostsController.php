<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->text = $request->text;
        $post->user_id = $request->user()->id;
        $post->save();
        return back()->with('messageSuccess', '投稿しました');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() == $post->user_id) {
            $data = [
                'post' => $post,
            ];
            return view('posts.edit', $data);
        } else {
            return back();
        }
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->text = $request->text;
        $post->save();
        return redirect('/')->with('messageSuccess', '投稿を更新しました');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() == $post->user_id) {
            $post->delete();
        }
        return back()->with('messageSuccess', '投稿を削除しました');
    }
}
