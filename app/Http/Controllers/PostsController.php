<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        return view('posts.edit', [
            'post' => $post,
        ]);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:140',
        ]);

        $post->content = $validated['content'];

        $post->save();

        return redirect('/');
    }
}
