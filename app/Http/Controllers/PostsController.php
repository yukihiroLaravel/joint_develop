<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Post;
use App\Tag;
use App\Http\Requests\PostRequest; 
use App\Http\Requests\UsertRequest;

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

    public function detachTag(Post $post, Tag $tag)
    {
        // 投稿者本人チェック
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }
        $post->tags()->detach($tag->id);

        return back();
    }

    // 投稿の編集
    public function edit(Post $post)
    {
        //ログインユーザーの確認
        if(Auth::id() !== $post->user_id){
            abort(403);
        }
        $tags = Tag::orderBy('name')->get();
        return view('edits.edit', compact('post', 'tags'));
    }

    // 更新処理
    public function update(UserRequest $request, Post $post)
    {
        // 投稿者本人かチェック
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        $post->update($request->validated());
            return redirect('/')->with('success', '投稿を更新しました');
    }

    //画像の登録
    public function editImage(Post $post)
    {
    if (Auth::id() !== $post->user_id) {
        abort(403);
    }

    return view('posts.image_edit', compact('post'));
    }

    //削除処理
    public function destroy(Post $post)
    {
    if (Auth::id() !== $post->user_id) {
        abort(403);
    }

    $post->delete();
    return redirect('/')->with('success', '削除しました');
    }
}
