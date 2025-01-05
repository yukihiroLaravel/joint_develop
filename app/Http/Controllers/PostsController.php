<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            // 保存されていた画像を削除する
            Storage::delete($post->image);
            $post->delete();
        }
        return back();
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        // 画像の情報を取得
        $image = $request->file('image');

        $post->content = $request->content;
        $post->user_id = $request->user()->id;

        // 画像をアップロードした場合
        if ($image !== null){

            // DBからアップロードした名前が同じものがあるか検索
            $imageName = Post::where('image', 'public/images/' . $image->getClientOriginalName())->first();

            // storage/app/public/imagesフォルダに保存される
            // 同じ画像名が存在する場合は、適当な名前で保存
            if ($imageName !== null) {
                $post->image = $image->store('public/images');
            } else {
                // 同じ画像名が存在しない場合は、アップロードした画像名で保存
                $post->image = $image->storeAs('public/images', $image->getClientOriginalName());
            }
        }
        
        $post->save();
        return back();
    }

    // 投稿編集画面
    public function edit($id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);
        // 投稿者以外であればエラーを出す
        if ($user->id !== $post->user_id) {
            abort(403);
        }
        $data = [
            'post' => $post,
        ];
        return view('posts.edit', $data);
    }

    // 投稿更新
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        // 画像の情報を取得
        $image = $request->file('image');

        $post->content = $request->content;

        // 画像をアップロードした場合
        if ($image !== null){

            // DBからアップロードした名前が同じものがあるか検索
            $imageName = Post::where('image', 'public/images/' . $image->getClientOriginalName())->first();

            // storage/app/public/imagesフォルダに保存される
            // 同じ画像名が存在する場合は、適当な名前で保存
            if ($imageName !== null) {
                $post->image = $image->store('public/images');
            } else {
                // 同じ画像名が存在しない場合は、アップロードした画像名で保存
                $post->image = $image->storeAs('public/images', $image->getClientOriginalName());
            }
        }
        $post->save();
        return redirect("/");
    }

    // 画像のみ削除
    public function imageDestroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            // 保存されていた画像を削除する
            Storage::delete($post->image);
            $post->image = null;
            $post->save();
        }
        return back();
    }
}
