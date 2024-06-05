<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use App\Tag;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::with(['comments' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->orderBy('id', 'desc')->paginate(10);
        
        $tags = Tag::orderBy('id')->get();
        return view('welcome', [
            'posts' => $posts,
            'tags' => $tags,
        ]);
    }
    
    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->user_id = \Auth::id();
        $post->content = $request->content;
        $post->tag_id = $request->tag;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('images', $filename, 'public');
            $post->image_path = 'storage/' . $path;
        }
        $post->save();
        session()->flash('flash_message', '登録しました！');
        return back();
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() == $post->user_id) {
            return view('posts.edit', ['post' => $post]);
        } else {
            abort(403);
        }
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();
        session()->flash('flash_message', '投稿を更新しました！');
        return redirect('/');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        session()->flash('flash_message', '投稿を削除しました！');
        return back();
    }
}
