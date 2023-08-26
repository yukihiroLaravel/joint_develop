<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function store(PostRequest $request)
    {
        $post = new Post;
        if (isset($request->image)) {
            // ディレクトリ名
            $dir = 'images';
            // アップロードされたファイル名を取得
            $file_name = $request->file('image')->getClientOriginalName();
            // 取得したファイル名で保存
            $request->file('image')->storeAs('public/' . $dir, $file_name);
            
            $post->image = 'storage/' . $dir . '/' . $file_name;
        }
        $post->text = $request->text;
        $post->user_id = $request->user()->id;
        $post->save();
        return back()->with('messageSuccess', '投稿しました');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() == $post->user_id) {
            $data = [
                'post' => $post,
            ];
            return view('posts.edit', $data);
        } else {
            return back();
        }
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        if (isset($request->image)) {
            // ディレクトリ名
            $dir = 'images';
            // アップロードされたファイル名を取得
            $file_name = $request->file('image')->getClientOriginalName();
            // 取得したファイル名で保存
            $request->file('image')->storeAs('public/' . $dir, $file_name);

            $post->image = 'storage/' . $dir . '/' . $file_name;
        } 
        $post->text = $request->text;
        $post->save();
        return redirect('/')->with('messageSuccess', '投稿を更新しました');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() == $post->user_id) {
            $post->delete();
        }
        return back()->with('messageSuccess', '投稿を削除しました');
    }

    public function destroyImage($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() == $post->user_id) {
            $post->image = null;
            $post->save();
        }
        return back()->with('messageSuccess', '画像を削除しました');
    }

    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        if (!empty($keyword)) {
            $posts = Post::where('text', 'LIKE', "%{$keyword}%")->get();
        }
        // if (empty($posts)) {
        //     $posts = null;
        // }
        // dd($posts);
        return view('posts.search', compact('posts', 'keyword'));
    }

    // public function index(Request $request)
    // {
    //     $keyword = $request->input('keyword');

    //     $query = Post::query();
    //     //入力されたキーワードでpostsテーブルのtextカラムを検索
    //     if(!empty($keyword)) {
    //         $query->where('text', 'LIKE', "%{$keyword}%");
    //     }
    //     //ここの$postsには条件付きデータが入っている
    //     $posts = $query->get();
    //     dd($posts);

    //     return view('posts.search', compact('posts', 'keyword'));
    // }
}