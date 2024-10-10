<?php

namespace App\Http\Controllers;

use App\Post;
use App\Reply;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->post = $request->post;
        $post->user_id = $request->user()->id;

        // 画像or動画ファイルがアップロードされている場合
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $post->image_path = $path;
        }
        $post->scheduled_at = $request->input('scheduled_at');

        // 予約日時が設定されているかを確認
        if ($post->scheduled_at) {
            $post->is_published = false; // 予約投稿として設定
            $message = '予約投稿の設定が完了しました。';
        } else {
            $post->is_published = true; // 通常投稿は即時公開
            $message = '投稿が完了しました。';
        }

        $post->save();

        // フラッシュメッセージを設定
        return back()->with('status', $message);
    }

    public function index()
    {
        $posts = Post::where('is_published', true)->orderBy('updated_at', 'desc')->paginate(10);
        $uploadMaxSize = ini_get('upload_max_filesize');
        $data = [
            'posts' => $posts,
            'uploadMaxSize' => $uploadMaxSize
        ];
        return view('welcome', $data);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return back()->with('status', '投稿を削除しました。');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() == $post->user_id) {
            return view('posts.edit', ['post' => $post]);
        }
        abort(404);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->post = $request->post;
        $post->save();
        return redirect('/');
    }

    public function showReplyForm(Post $post)
    {
        // 返信をページネートして取得
    $replies = $post->replies()->with('user')->paginate(10);  // 1ページあたり10件の返信を表示
    
        // ビューに投稿と返信を渡す
        return view('reply.reply_form', [
            'post' => $post,
            'replies' => $replies,
        ]);
    }

public function reply(Request $request, Post $post)
{
    // バリデーション
    $request->validate([
        'reply' => 'required|max:140',
    ]);

    // 返信を保存する処理
    $reply = new Reply();
    $reply->reply = $request->input('reply');
    $reply->user_id = Auth::id();
    $reply->post_id = $post->id;
    $reply->save();

    return redirect()->back()->with('success', '返信を投稿しました');
}

public function deleteReply(Reply $reply)
{
    // 返信を削除する処理
    if (Auth::id() === $reply->user_id) {
        $reply->delete();
        return redirect()->back()->with('success', '返信を削除しました！');
    }

    return redirect()->back()->with('error', '返信の削除に失敗しました。');
}

}