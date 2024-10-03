<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->user_id = $request->user()->id;
        $post->content = $request->content;
        $post->save();
        return back();
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);

        if ($post->user_id !== $user->id) {
            abort(403, '許可されていない操作です。');
        }

        $data=[
            'post' => $post,
        ]; 
        
        return view('posts.edit', $data);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrfail($id);
        $post->user_id = $request->user()->id;
        $post->content = $request->content;
        $post->save();
        return redirect('/');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }

        return back();
    }

    public function searchPosts(Request $request)
    {
        $keyword = $request->input('keyword');
        if (!empty($keyword)) {
            $posts = Post::where('content', 'like', "%{$keyword}%")->orderBy('id', 'desc')->paginate(10);
        } else {
            $posts = Post::orderBy('id', 'desc')->paginate(10);
        }
        return view('welcome', ['posts' => $posts, 'keyword' => $keyword]);  
    } 
}
