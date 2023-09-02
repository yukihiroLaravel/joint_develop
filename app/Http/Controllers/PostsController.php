<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\PostRequest;
class PostsController extends Controller
{
    public function create()
    {
        $user = \Auth::user();
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
        $data = [
            'user' => $user,
            'posts' => $posts,
        ];
        return view('post.create', $data);
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->date = $request->date;
        $post->postcontent = $request->postcontent;
        $post->user_id = $request->user()->id;
        $post->save();
        return redirect("/");
    }
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return back();
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
        $data=[
            'user' => $user,
            'post' => $post,
            'posts' => $posts,
        ];
        return view('post.edit', $data);
    }
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->date = $request->date;
        $post->postcontent = $request->postcontent;
        $post->user_id = $request->user()->id;
        $post->save();
        return redirect("/");
    }
}
