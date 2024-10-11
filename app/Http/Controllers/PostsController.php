<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{   
    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->user_id = $request->user()->id;
        $post->content = $request->content;
        $post->save();
        return back();
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);

        if ($post->user_id !== $user->id) {
            abort(403, '許可されていない操作です。');
        }

        $data=[
            'post' => $post,
        ]; 
        
        return view('posts.edit', $data);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrfail($id);
        $post->user_id = $request->user()->id;
        $post->content = $request->content;
        $post->save();
        return redirect('/');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }

        return back();
    }

    // 通常のトップページと、投稿の検索機能も兼ねる
    public function index(Request $request)
    {
        $keyword = $request->input('keyword'); // リクエストからキーワードを取得
        $submitted = $request->has('keyword'); // キーワード（空でも良い）がリクエストに含まれていて「検索ボタン」を押されたかどうか確認
        $query = Post::query(); // Postモデルの新しいクエリビルダーインスタンスを作成
        if (!empty($keyword)) { // キーワードが空でない場合
            $query->where('content', 'like', "%{$keyword}%"); // contentカラムにキーワードが含まれる投稿を検索条件に追加
        } 
        $posts = $query->orderBy('id', 'desc')->paginate(10); // if文を通らなかったら、そのまま投稿を全件表示
        return view('welcome',
            [
                'posts' => $posts, 
                'keyword' => $keyword, 
                'submitted' => $submitted
            ]
        );
    } 
}
