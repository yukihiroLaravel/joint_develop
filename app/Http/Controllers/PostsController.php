<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Comment;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
        ]);
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->user_id = $request->user()->id;
        if ($request->text === null) {
            $post->text = '';
        } else {
            $post->text = $request->text;
        }
        $post->save();
        $img = $request->file('img_path');
        if ($img) {
            $path = $img->storeAs('public/img', $post->id . '.' . $request->img_path->extension());
            $post->img_path = $path;
            $post->save();
        }
        return back()->with('greenMessage', '投稿しました');
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);
        $data=[
            'user' => $user,
            'post' => $post,
        ];
        if ($post->user_id === \Auth::id()) {
            return view('posts.edit', $data);
        }
        abort(404);
    }

    public function update(postRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->text = $request->text;
        $post->user_id = $request->user()->id;
        $post->save();
        return redirect('/')->with('greenMessage', '投稿を編集しました');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return back()->with('redMessage', '削除しました');
    }

    public function search(Request $request)
    {
        $keywords = preg_split('/[\s　]+/u', $request->input('keywords'));
        $posts = Post::where(function ($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->where('text', 'LIKE', "%$keyword%");
            }
        })
            ->orWhere(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->whereHas('comments', function ($query) use ($keyword) {
                        $query->where('comment', 'LIKE', "%$keyword%");
                    });
                }
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        $request->flash();
        return view('welcome', ['posts' => $posts]);
    }
}
