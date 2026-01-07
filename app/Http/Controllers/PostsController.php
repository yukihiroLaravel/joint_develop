<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Post;
use App\Tag;
use App\Http\Requests\PostRequest; 

class PostsController extends Controller
{
    // トップページを表示 //
    public function index()
    {
        $tags = Tag::orderBy('name')->get();
        // 投稿順に表示させる //
        $posts = Post::with('user')->orderBy('created_at', 'desc')->paginate(10);

        // トップページに //
        return view('welcome', compact('posts', 'tags'));
    }
   
    // 投稿保存（タグ同時処理）
    public function store(PostRequest $request)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }
        
        // 投稿作成
        $post = Post::create([
            'content' => $request->content,
            'user_id' => $request->user()->id,
            'image'   => $imagePath,
        ]);

        // ① 既存タグ（checkbox）
        $tagIds = $request->input('tag_ids', []);

        // ② 新規タグ（カンマ区切り）
        if ($request->filled('new_tags')) {
            $names = array_unique(
                array_filter(array_map('trim', explode(',', $request->new_tags)))
            );

            foreach ($names as $name) {
                $tag = Tag::firstOrCreate(
                    ['name' => $name],
                    [
                        'user_id' => auth()->id(),
                        'update_count' => 0,
                    ]
                );
                $tagIds[] = $tag->id;
            }
        }
        // ③ 紐付け
        $post->tags()->sync($tagIds);

        return back();
    }

    public function edit(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        $tags = Tag::orderBy('name')->get();

        return view('posts.edit', [
            'post' => $post,
            'tags' => $tags,
        ]);
    }

    public function update(PostRequest $request, Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        // 本文更新
        $post->update([
            'content' => $request->content,
        ]);

        // ① 既存タグ
        $tagIds = $request->input('tag_ids', []);

        // ② 新規タグ
        if ($request->filled('new_tags')) {
            $names = array_unique(
                array_filter(array_map('trim', explode(',', $request->new_tags)))
            );

            foreach ($names as $name) {
                $tag = Tag::firstOrCreate(
                    ['name' => $name],
                    [
                        'user_id' => auth()->id(),
                        'update_count' => 0,
                    ]
                );
                $tagIds[] = $tag->id;
            }
        }

        // ③ タグ更新
        $post->tags()->sync($tagIds);

        return redirect()->route('user.show', $post->user_id);
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

    // 投稿削除
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (\Auth::id() === $post->user_id){
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            
            $post->delete();
        }
        
        return back();
    }

    // 画像編集ページ表示
    public function editImage(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        return view('posts.image_edit', [
            'post' => $post,
        ]);
    }

    // 画像更新
    public function updateImage(Request $request, Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        // 古い画像削除
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        // 新しい画像保存
        $path = $request->file('image')->store('posts', 'public');

        $post->update([
            'image' => $path,
        ]);

        return redirect()->route('posts.edit', $post->id);
    }

    // 画像削除
    public function destroyImage(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->update([
            'image' => null,
        ]);

        return redirect()->route('posts.edit', $post);
    }
}
