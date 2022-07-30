<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
// use App\Http\Controllers\Controller;
use App\Http\Requests\PostEditRequest;

class PostsController extends Controller
{
    public function edit($id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);

        return view('posts.edit', [
            'user' => $user,
            'post' => $post,
        ]);
    }
    public function update(PostEditRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->content = $request->content;

        $post->save();
        return redirect('/');
    }
}
