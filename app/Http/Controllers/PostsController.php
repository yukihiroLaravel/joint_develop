<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Post;


class PostsController extends Controller
{
     public function index(Request $request)
    {
        $search = $request->input('keyword');  //リクエストからkeywordパラメーターの値を取得し、$search変数に代入、ユーザーが検索フォームに入力したキーワードが格納される
        $query = Post::query();   //モデルに対してクエリビルダを作成し、$query変数に代入してこのクエリビルダを使ってデータベースクエリを構築

        if (!empty($search)) {  //$search変数が空でない時、ユーザーがキーワードを入力した場合に、検索条件を追加
            $query->where('content', 'LIKE', "%{$search}%");  //contentカラムがユーザーの入力したキーワードを部分一致で含む場合に検索条件を追加する。% はワイルドカード文字で、任意の文字列を表す
        }
        $posts = $query->orderBy('id','desc')->paginate(10);  //クエリビルダに対して、id カラムで降順に並び替えを行い、ページネーションを適用し取得するデータは1ページあたり10件
        return view('welcome', ['posts' => $posts, 'search' => $search]);  //welcome ビューにデータを渡して、ビューを表示、$posts変数には検索結果が格納され、$search 変数にはユーザーが入力したキーワードが格納。ビュー内でこれらの変数を使用して結果を表示
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        //withメソッドを使用して投稿削除フラッシュメッセージを記述
        return redirect()->route('posts.index')->with('redMessage', '投稿を削除しました。');
    }

    public function edit($id) 
    {
        $post = Post::findOrFail($id);
        if(\Auth::id() == $post->user_id) {
            return view('posts.edit', ['post' => $post]);
        } else{
            abort(404);
        }
    }

    public function update(PostRequest $request, $id) 
    {
        $post = Post::findOrFail($id);
        $post->content = $request->content;
        $post->save();
        //withメソッドを使用して投稿編集フラッシュメッセージを記述
        return redirect()->route('posts.index')->with('greenMessage','更新が成功しました。'); 
    }
}
