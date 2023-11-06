<?php

namespace App\Http\Controllers;
use App\User;
use App\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        
        return back();
    }

    public function index() {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('welcome', ['posts' => $posts]);
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();
        return back();
    }

    //投稿編集画面へ遷移
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            return view("posts.post_edit",["post" => $post]);
        }
        else {
            return back();
        }
    }
    //投稿編集処理
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
         if (\Auth::id() === $post->user_id) {
            $post->content = $request->content;
            $post->save();
            return redirect('/');
        }

        return back();
    }
}
