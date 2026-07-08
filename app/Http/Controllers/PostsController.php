<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Reaction;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(10);
        return view('welcome',[
            'posts' => $posts,
        ]);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        // リアクション集計表示でも同じ順番を使うため、資料の並び順に合わせる（Reactionモデル内で定数化）
        $reactionTypes = Reaction::TYPES;

        $myReaction = $post->reactions()
            ->where('user_id', Auth::id())
            ->first();

        $encouragementReactions = $post->reactions()
            ->with('user')
            ->whereHas('user')
            ->whereNotNull('encouragement')
            ->where('encouragement', '<>', '')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('posts.show', [
            'post' => $post,
            'reactionTypes' => $reactionTypes,
            'myReaction' => $myReaction,
            'encouragementReactions' => $encouragementReactions,
        ]);
    }

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

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        $validated = $request->validated();

        $post->content = $validated['content'];
        $post->save();

        return redirect('/');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        $post->delete();

        return redirect("/");
    }

    public function store(PostRequest $request)
    {
        $request->user()->posts()->create([
            'content' => $request->content,
        ]);

        return back();
    }
}