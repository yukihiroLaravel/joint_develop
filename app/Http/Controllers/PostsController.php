<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\PostImage;
use App\Http\Requests\PostRequest;
use App\Tag;

class PostsController extends Controller
{
    public function show($id)
    {
        $post = Post::with(['user', 'images', 'tags'])->findOrFail($id);
        $replies = $post->replies()
                    ->with('user')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        $data = [
            'post' => $post,
            'replies' => $replies,
        ];
        return view('posts.show', $data);
    }

    public function index()
    {
        $posts = Post::with(['user', 'images'])
            ->withCount('replies') 
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $users = collect(); // 空のコレクション
        $keyword = null;   // キーワードなし
        $type = 'posts';   // デフォルトを投稿検索にしておく

        return view('welcome', ['posts' => $posts]);
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = \Auth::id();
        $post->save();

        // 画像保存処理
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('uploads', 'public');

                PostImage::create([
                    'post_id'   => $post->id,
                    'file_name' => $imageFile->getClientOriginalName(),
                    'file_path' => $path,
                ]);
            }
        }

        // タグ保存処理
        if ($request->filled('tags')) {
            $tags = collect(explode(',', $request->input('tags')))
                        ->map(fn($tag) => trim($tag)) // 前後の空白除去
                        ->filter() // 空文字除外
                        ->unique(); // 重複除外
            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $post->tags()->sync($tagIds);
        }

        return back()->with('success', '投稿が完了しました！');
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);
        $data=[
            'user' => $user,
            'post' => $post,
        ];
        return view('posts.edit', $data);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() !== $post->user_id) {
            abort(403);
        }
        $post->content = $request->content;
        $post->save();

        // 画像削除処理
        if ($request->filled('delete_images')) {
            $deleteIds = $request->input('delete_images');
            
            PostImage::whereIn('id', $deleteIds)
                ->where('post_id', $post->id)
                ->delete();
        }

        // 画像追加処理
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('uploads', 'public');

                PostImage::create([
                    'post_id'   => $post->id,
                    'file_name' => $imageFile->getClientOriginalName(),
                    'file_path' => $path,
                ]);
            } 
        }

        // タグ更新処理
        if ($request->filled('tags')) {
            $tags = collect(explode(',', $request->input('tags')))
                    ->map(fn($tag) => trim($tag))
                    ->filter()
                    ->unique();       
            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $post->tags()->sync($tagIds);
        } else {
            // タグが空の場合、全てのタグを解除
            $post->tags()->detach();
        }
        return redirect('/')->with('success', '投稿を更新しました！');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() !== $post->user_id) {
            abort(403);
        }
        foreach ($post->images as $image) {
            \Storage::disk('public')->delete($image->file_path);
            $image->forceDelete();
        }
        $post->forceDelete();
        return back()->with('success', '投稿を削除しました！'); 
    }

}