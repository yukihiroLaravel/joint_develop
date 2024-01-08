<?php

namespace App\Http\Controllers;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PostsController extends Controller
{
    // 投稿削除
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id){
            $post->delete();
        }
        return back()->with('message', '投稿を削除しました！');
    }


    //投稿作成

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:140',
        ]);

        $post = new Post();
        $post->content = $request->input('content');
        $post->user_id = Auth::id();
        
        // 画像フォームでリクエストした画像を取得
        $img = $request->file('img_path');

        // 画像情報がセットされていれば、保存処理を実行
        if (isset($img)) {
            // storage > public > img配下に画像が保存される
            $img_path = $img->store('img','public');
            // store処理が実行できたらDBに保存処理を実行
            
        $post->img_path = $img_path;
        }
        
        $post->save();


        return redirect('/');
    }
}
