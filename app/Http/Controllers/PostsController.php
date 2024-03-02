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
    
        // 検索結果の取得
        $posts = Post::orderBy('created_at', 'desc');
    
        if (!empty($keyword)) {
            $posts->where('text', 'like', '%' . $keyword . '%');
        }
    
        $posts = $posts->paginate(10);
    
        // ビューに渡すデータを準備
        $data = [
            'posts' => $posts,
            'keyword' => $keyword,
        ];
    
        // ビューにデータを渡して返す
        return view('welcome', $data);
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
