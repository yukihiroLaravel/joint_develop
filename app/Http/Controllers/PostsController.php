<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\PostRequest; 

class PostsController extends Controller
{
    // トップページを表示 //
    public function index()
    {
        // 投稿順に表示させる //
        $posts = Post::with('user')->orderBy('created_at', 'desc')->paginate(10);

        // トップページに //
        return view('welcome', compact('posts'));
    }
    // ユーザーの投稿一覧 //
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
        $data=[
            'user' => $user,
            'posts' => $posts,
        ];
        return view('users.show', $data);
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
        $user = User::findOrFail($id);        
        $user->delete();
        return redirect('/');
    }
}
