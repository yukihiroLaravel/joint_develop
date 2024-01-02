<?php

namespace App\Http\Controllers;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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


    //投稿作成

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:140',
        ]);

        $post = new Post();
        $post->content = $request->input('content');
        $post->user_id = Auth::id();
        $post->save();

        return redirect('/');
    }
}
