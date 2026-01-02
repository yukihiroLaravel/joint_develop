<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::withCount('favoriteUsers')->orderBy('id','desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
            'ranking_posts' => $this->getRanking(),
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $query = Post::withCount('favoriteUsers');

        if (!empty($keyword)) {
            $query->where('content', 'LIKE', "%{$keyword}%");
        }

        $posts = $query->orderBy('id', 'desc')->paginate(10);
        $posts->appends(['keyword' => $keyword]);

        return view('welcome', [
            'posts' => $posts,
            'ranking_posts' => $this->getRanking(),
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
        return back();
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
        return redirect('/');
    }
}
