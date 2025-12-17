<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Post;
use App\Tag;
use App\Http\Requests\PostRequest; 

class PostsController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('name')->get();
        return view('welcome', compact('tags'));
    }

    // 投稿保存（タグ同時処理）
    public function store(PostRequest $request)
    {
        // 投稿作成
        $post = Post::create([
            'content' => $request->content,
            'user_id' => $request->user()->id,
        ]);

        // ① 既存タグ（checkbox）
        $tagIds = $request->input('tag_ids', []);

        // ② 新規タグ（カンマ区切り）
        if ($request->filled('new_tags')) {
            $names = array_unique(
                array_filter(array_map('trim', explode(',', $request->new_tags)))
            );

            foreach ($names as $name) {
                $tag = Tag::firstOrCreate(['name' => $name]);
                $tagIds[] = $tag->id;
            }
        }

        // ③ 紐付け
        $post->tags()->sync($tagIds);

        return back(); 
    }

    public function detachTag(Post $post, Tag $tag)
    {
        // 投稿者本人チェック
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }
        $post->tags()->detach($tag->id);

        return back();
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/');
    }
}
