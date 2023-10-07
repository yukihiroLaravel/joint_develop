<?php

namespace App\Http\Controllers;

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
}
