<?php

namespace App\Http\Controllers;
use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        //投稿をキーワード検索
        $keyword = $request->input('keyword');
        $query = Post::query();
        if (!empty($keyword)){
            $query->where('content', 'LIKE', "%{$keyword}%");
        }
        $posts = $query->orderBy('id', 'desc')->paginate(10);
        return view('welcome', ['posts'=> $posts, 'keyword'=> $keyword]);
    }

    // 投稿削除
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id){
            $post->delete();
        }
        return back()->with('message', '投稿削除しました！');
    }

    public function upload(Request $request)
    {
        // ディレクトリ名
        $dir = 'sample';

        // アップロードされたファイル名を取得
        $file_name = $request->file('image')->getClientOriginalName();

        // 取得したファイル名で保存
        $request->file('image')->storeAs('public/' . $dir, $file_name);

         // ファイル情報をDBに保存
         $image = new Image();
         $image->name = $file_name;
         $image->path = 'storage/' . $dir . '/' . $file_name;
         $image->save();

        return redirect('/');
    }

}
