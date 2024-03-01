<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function index()
   {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
        ]);
   
    }

   public function store(PostRequest $request)
    {
        $user = \Auth::user();
        $post = new Post;
        $post->user_id = $user->id;
        $post->text = $request->text;
        $post->save();
        return back();
    }

    public function search(Request $request)
    {
        // リクエストからキーワードを取得
        $keyword = $request->input('keyword');

        // キーワードが空でない場合に検索を実行
        if (!empty($keyword)) {
            // クエリの作成
            $posts = Post::where('text', 'like', '%' . $keyword . '%')
                         ->orderBy('created_at', 'desc')
                         ->paginate(10);

            // 検索結果をビューに渡す
            return view('welcome', compact('posts', 'keyword'));
        } else {
            // キーワードが空の場合はすべての投稿を取得して表示
            $posts = Post::orderBy('created_at', 'desc')->paginate(10);

            // 全投稿をビューに渡す
            return view('welcome', [
                'posts' => $posts,
            ]);
        }
    }
    
    public function destroy($id)
    {
        $posts = Post::findOrFail($id);
        if (\Auth::id() === $posts->user_id) {
           $posts->delete();
        }
        return back();
    }
}
