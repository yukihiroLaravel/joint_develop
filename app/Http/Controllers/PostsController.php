<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Tag;
use App\Http\Requests\PostRequest; 

class PostsController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('name')->get();
        $posts = Post::with(['user', 'tags'])->orderBy('id', 'desc')->paginate(9);

        return view('welcome', compact('posts', 'tags'));
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

        return redirect()->back();
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/');
    }
}
