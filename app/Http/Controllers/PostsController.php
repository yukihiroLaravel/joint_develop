<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
        ]);
    }

    public function keyword(Request $rq)
    {
    //キーワード受け取り
    $keyword = $rq->input('keyword');

    // キーワードが空の場合の処理
    if (empty($keyword)) {
        return redirect('/')->with([
            'flash_msg' => 'キーワードを入力してください',
            'cls' => 'warning'
        ]);
    }

    //クエリ生成
    $query = \App\Post::query();
    
    //もしキーワードがあったら
    if(!empty($keyword))
    {
        $query->where('content','like',"%{$rq->keyword}%");
    }
    // 全件取得 +ページネーション
        $posts = $query->orderBy('id','desc')->paginate(10);
        $keyword_result = '検索の結果'.count($posts). '件';
        return view('welcome',['posts'=> $posts,
        'keyword_result'=>$keyword_result]);
    }   

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            return view('posts.edit',['post' => $post,
        ]);
        }
        return back();
    }   
    
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id){
            $post->content = $request->content;
            $post->save();
            return redirect('/')->with('flashSuccess', '投稿を編集しました。');
        } 
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return back()->with('flashSuccess', '投稿を削除しました。');
    }
    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();
        return back()->with('flashSuccess', '投稿しました。');
    }
}