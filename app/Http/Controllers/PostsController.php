<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post; //Postモデルを使用する為のインポート、投稿データを取得する為に使用
use App\User; //Userモデルを使用する為のインポート、ユーザーデータを取得する為に使用
use App\Http\Requests\PostRequest; //フォームリクエストの宣言（バリデーションを切り分ける）
use Illuminate\Support\Facades\Auth; // Authファサードをインポート
use Illuminate\Support\Facades\Log;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        // 検索キーワードを取得
        $keyword = $request->input('keyword', '');  // デフォルト値として空の文字列を設定

        // Postクエリを初期化
        $query = Post::query();

        // キーワードが存在する場合は検索条件を追加
        if (!empty($keyword)) {
            $keywords = mb_split('\s+', $keyword);  // マルチバイト文字の空白文字でキーワードを分割
            Log::info('Search keywords: ', $keywords); // ログ出力
            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->orwhere('content', 'LIKE', "%{$word}%");
                }
            });
        }

        // 投稿をIDの降順で並べ替えてページネーション
        $posts = $query->orderBy('id', 'desc')->paginate(10);

        // ビューに渡すデータを指定
        return view('welcome', compact('posts', 'keyword'));
    }
    
    //通常のRequestクラスの代わりにPostRequestクラスをメソッドの引数として指定
    public function store(PostRequest $request) //これにより、メソッドが呼び出される前に自動的にリクエストデータがバリデーションされる
    {
        $post = new Post; //$postをオブジェクト化
        $post->content = $request->content; //welcome.blade.phpの<form>内で入力したcontentがname属性として$requestに代入される
        $post->user_id = $request->user()->id; //Laravelが自動でログインユーザ情報を$requestの中に入れる
        $post->save();
        return back()->with('success', 'ポストの投稿に成功しました。');
    }

    // 投稿編集ページ
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        // ユーザー認証チェック
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('top')->with('error', 'アクセス権限がありません。');
        }

        return view('posts.edit', compact('post'));
    }

    // 投稿編集処理
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        // ユーザー認証チェック
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('top')->with('error', 'アクセス権限がありません。');
        }

        $post->content = $request->content;
        $post->save();

        return redirect()->route('top')->with('success', 'ポストの更新に成功しました。');
    }

    // 投稿削除
    public function destroy($post)
    {
        $post = post::findOrFail($post);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return back();
    }
}

    