<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Reply;
use App\Post;
use Illuminate\Support\Facades\Storage;

class ReplyController extends Controller
{
    // 返信画面
    public function index($id)
    {
        $post = Post::findOrFail($id);
        $replies = Reply::orderBy('id', 'desc')->where('post_id', $post->id)->paginate(10);
        $data = [
            'post' => $post,
            'replies' => $replies,
        ];
        return view('replies.reply' , $data);
    }
    
    // 返信機能
    public function store(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $reply = new Reply();
        // 画像の情報を取得
        $image = $request->file('image');

        $reply->user_id = $request->user()->id;
        $reply->post_id = $post->id;
        $reply->content = $request->content;

        // 画像をアップロードした場合
        if ($image !== null){

            // DBからアップロードした名前が同じものがあるか検索
            $imageName = Reply::where('image', 'public/images/replies/' . $image->getClientOriginalName())->first();

            // storage/app/public/images/repliesフォルダに保存される
            // 同じ画像名が存在する場合は、適当な名前で保存
            if ($imageName !== null) {
                $reply->image = $image->store('public/images/replies');
            } else {
            // 同じ画像名が存在しない場合は、アップロードした画像名で保存
                $reply->image = $image->storeAs('public/images/replies', $image->getClientOriginalName());
            }
        }

        $reply->save();
        return back();
    }

    // 返信編集画面
    public function edit($id)
    {
        $user = \Auth::user();
        $reply = Reply::findOrFail($id);
        // 投稿者以外であればエラーを出す   
        if($user->id !== $reply->user_id){
            abort(403);
        }
        return view('replies.edit', [
            'reply' => $reply,
        ]);
    }

    // 返信編集更新
    public function update(PostRequest $request, $id)
    {
        $reply = Reply::findOrFail($id);
        // 画像の情報を取得
        $image = $request->file('image');

        $reply->content = $request->content;

        // 画像をアップロードした場合
        if ($image !== null){

            // DBからアップロードした名前が同じものがあるか検索
            $imageName = Reply::where('image', 'public/images/replies' . $image->getClientOriginalName())->first();

            // storage/app/public/images/repliesフォルダに保存される
            // 同じ画像名が存在する場合は、適当な名前で保存
            if ($imageName !== null) {
                $reply->image = $image->store('public/images/replies');
            } else {
            // 同じ画像名が存在しない場合は、アップロードした画像名で保存
                $reply->image = $image->storeAs('public/images/replies', $image->getClientOriginalName());
            }
        }

        $reply->save();
        return redirect(route('post.reply', [
            'id' => $reply->post_id,
        ]));
    }

    // 返信削除
    public function destroy($id)
    {
        $reply = Reply::findOrFail($id);
        if (\Auth::id() === $reply->user_id) {
            // 保存されていた画像を削除する
            Storage::delete($reply->image);
            $reply->delete();
        }
        return back();
    }

    // 画像のみ削除
    public function imageDestroy($id)
    {
        $reply = Reply::findOrFail($id);
        if (\Auth::id() === $reply->user_id) {
            // 保存されていた画像を削除する
            Storage::delete($reply->image);
            $reply->image = null;
            $reply->save();
        }
        return back();
    }
}
