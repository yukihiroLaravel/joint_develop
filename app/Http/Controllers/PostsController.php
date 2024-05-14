<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post; //Postモデルを使用する為のインポート、投稿データを取得する為に使用
use App\User; //Userモデルを使用する為のインポート、ユーザーデータを取得する為に使用
use App\Http\Requests\PostRequest; //フォームリクエストの宣言（バリデーションを切り分ける）
use Illuminate\Support\Facades\Auth; // Authファサードをインポート

class PostsController extends Controller
{
    public function index() //Postモデルから投稿情報を取得
    {
        //DB上の全投稿情報をid順で降順に並べ換える
        //->paginate(10)⇒1ページに10個のアイテムを表示するように指定
        $posts = Post::orderBy('id','desc')->paginate(10);

        //第一引数にはviewの名前を指定
        //第二引数にはviewに渡すデータを連想配列で指定し、「$posts」をviewの'welcome.blade.php'に投稿一覧を渡す記述
        return view('welcome', [
            'posts' => $posts,
        ]);
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

    