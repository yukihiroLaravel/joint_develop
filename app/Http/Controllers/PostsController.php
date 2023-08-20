<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
        ]);
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->user_id) {
            $user->delete();
        }
        return back();
    }
}
