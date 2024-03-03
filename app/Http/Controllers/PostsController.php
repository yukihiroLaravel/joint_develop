<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Http\Requests\PostRequest;

use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10, ["*"], 'posts-page')->appends(["users-page" => $request->input('users-page')]);
        $users = User::orderBy('id', 'desc')->paginate(10, ["*"], 'users-page')->appends(["posts-page" => $request->input('posts-page')]);
        $data = [
            'posts' => $posts,
            'users' => $users,
        ];
        return view('welcome', $data);
    }

    public function store(PostRequest $request)
    {
        $user = Auth::user();

        $post = new Post;
        $post->user_id = $user->id;
        $post->content = $request->content;
        $post->save();

        return back();
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return back();
    }
}
