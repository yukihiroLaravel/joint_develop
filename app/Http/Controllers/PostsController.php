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
    public function index(Request $request)
    {
        // 初回アクセスの確認
        $initialVisit = false;
        if (!session()->has('visited')) {
            session(['visited' => true]);
            $initialVisit = true;
        }
        // ログイン直後のアクセスの確認
        if (session()->has('logged_in')) {
            session()->forget('logged_in');
            $initialVisit = true;
        }
        // キーワード受け取り
        $keyword = $request->input('keyword');
        // クエリ生成
        $query = Post::query();
        // キーワードが空の場合の処理
        if (empty($keyword)) {
            // 初回アクセス時の全件取得 + ページネーション
            $posts = Post::orderBy('id', 'desc')->paginate(10);
            // アクセス時にはフラッシュメッセージを表示しない
            if (!$initialVisit) {
                session()->flash('flash_msg', 'キーワードを入力してください');
                session()->flash('cls', 'alert-warning');
            }
            return view('welcome', [
                'posts' => $posts,
                'keyword_result' => '',
                'keyword' => $keyword,
            ]);
        }
        // キーワードがある場合はフラッシュメッセージを削除
        session()->forget('flash_msg');
        session()->forget('cls');
        // キーワードがあった場合のクエリ
        $query->where('content', 'like', "%{$keyword}%");
        // 全件取得 + ページネーション
        $posts = $query->orderBy('id', 'desc')->paginate(10);
        $keyword_result = '検索の結果 ' . $posts->total() . ' 件';
        // フラッシュメッセージをクリア
        session()->forget('flashSuccess');
        return view('welcome', [
            'posts' => $posts,
            'keyword_result' => $keyword_result,
            'keyword' => $keyword,
        ]);
    }
    
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            return view('posts.edit',[
                'post' => $post,
            ]);
        }
        return back();
    }   
    
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
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

