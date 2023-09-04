<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Post;
use App\Http\Request\PostsRequest;
class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
        ]);
    }
    public function store(PostsRequest $request)
    {
        $post = new Post;
        $post->user_id = $request->user()->id;
        $post->text = $request->text;
        $post->save();
        return back()->with('successMessage', '登録に成功しました。');
    }
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if ($post->user_id === \Auth::id()) {
                $data = [
                    'post' => $post,
                ];
                return view('posts.edit', $data);
        }
        abort(404);
    }
    public function update(PostsRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->text = $request->text;
        $post->user_id = $request->user()->id;
        $post->save();
        return redirect('/');
        return back();
    }
}