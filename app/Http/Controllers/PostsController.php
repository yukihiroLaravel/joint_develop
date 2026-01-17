<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $query = Post::query();
        if (!empty($keyword)) {
            $query->where('content', 'LIKE', "%{$keyword}%");
        }
        $posts = $query->orderBy('id', 'desc')->paginate(10);
        $posts->appends(['keyword' => $keyword]);
        $ranking_posts = $this->getRanking();
        return view('welcome', [
            'posts' => $posts,
            'ranking_posts' => $ranking_posts,
            'keyword' => $keyword,
        ]);
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->favorite_flag = $request->favorite_flag ? 1 : 0;
        $post->save();
        return back()->with('success','投稿しました');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() !== $post->user_id) {
            return redirect('/');
        }
        return view('posts.edit', [
            'post' => $post,
        ]);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->content = $request->content;
            $post->save();
        }
        return redirect('/')->with('success','投稿を更新しました');
    }
}
