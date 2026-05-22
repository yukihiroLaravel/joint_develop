<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;   // 追記
use App\Post;   // 追記
use App\Http\Requests\PostRequest; // 追記

class PostsController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);
        if ($user->id === $post->user_id) {
            $data = [
                'user' => $user,
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
        $post->content = $request->content;
        $post->save();
        return redirect('/');
    }

}
