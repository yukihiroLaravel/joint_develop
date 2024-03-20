<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Str;
use App\Post;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
        ]);
    }

    public function store(PostRequest $request) {
        $fileName = 'images';
        $image = $request->file('image'); // リクエストから画像ファイルを取得します
        if(isset($image)) {
            // 拡張子を取得します
            $ext = $image->guessExtension();
            // アップロードファイル名は [ランダム文字列20文字].[拡張子] になります
            $filename = Str::random(20) . ".{$ext}";
            // publicディスク(storage/app/public/)のimagesディレクトリに画像を保存します
            $path = $image->storeAs('images', $filename, 'public');
        }
    
        $posts = new Post;
        $posts->content = $request->content ?? null;
        // 保存した画像のパスを使用します
        $posts->image = $path ?? null; // 画像がアップロードされなかった場合に備えて null を設定します
        $posts->user_id = $request->user()->id;
    
        $posts->save();
        return back()->with('successMessage', '投稿に成功しました');
    }
    
    //投稿の編集
    public function edit($id) {
        $user = \Auth::user();
        $post = Post::findOrFail($id);
    
        if (\Auth::check() && \Auth::id() == $post->user_id) {
            return view('posts.edit', ['post' => $post]);
        }
        abort(404);
    }
    //投稿内容の変更
    public function update(PostRequest $request, $id) {
        $fileName = 'images';
        $image = $request->file('image'); // リクエストから画像ファイルを取得します
        if(isset($image)) {
            // 拡張子を取得します
            $ext = $image->guessExtension();
            // アップロードファイル名は [ランダム文字列20文字].[拡張子] になります
            $filename = Str::random(20) . ".{$ext}";
            // publicディスク(storage/app/public/)のimagesディレクトリに画像を保存します
            $path = $image->storeAs('images', $filename, 'public');
        }


        $post = Post::findOrFail($id);
        $post->content = $request->content;
        $post->image = $path ?? null;
        $post->user_id = $request->user()->id;
        $post->save();
        return redirect('/')->with('updateSuccessMessage', '投稿を更新しました');
    }
    //投稿の削除
    public function destroy($id) {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return redirect('/')->with('deleteMessage', '投稿を削除しました');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $posts = Post::where('content', 'like', "%{$search}%")
        ->orderBy('id', 'desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
        ]);
    }
}
