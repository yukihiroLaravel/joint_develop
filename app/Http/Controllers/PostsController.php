<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use App\Post;
use App\Http\Requests\PostEditRequest;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('welcome', [ 
            'posts' => $posts,    
        ]);
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = \Auth::id();        
        $post->save();
        return redirect('/');
    }

    public function edit($id)
    {
        try {
                throw new \Exception; 
                $user = \Auth::user();
                $post = Post::findOrFail($id);
                if (\Auth::id() === $post->user_id) {
                    return view('posts.edit', [
                        'user' => $user,
                        'post' => $post,
                    ]);
                }
                $request->session()->flash('content', '投稿を変更しました');
        } catch(\Exception $e) {
                $request->session()->flash('error_content', '投稿の編集が失敗しました');
        }
        return back();
    }
    
    public function update(PostEditRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->content = $request->content;
            $post->save();
        }
        return redirect('/');
    }
}
