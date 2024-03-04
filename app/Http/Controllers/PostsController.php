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
    
        // キーワードが空でない場合は分割する
        $keywords = !empty($keyword) ? explode(' ', $keyword) : [];
    
        // 検索結果の取得
        $posts = Post::orderBy('created_at', 'desc');
    
        // キーワードが指定されている場合は、各キーワードに対して検索条件を追加する
        if (!empty($keywords)) {
            $posts->where(function ($query) use ($keywords) {
                foreach ($keywords as $key => $word) {
                    if ($key === 0) {
                        $query->where('text', 'like', '%' . $word . '%');
                    } else {
                        $query->orWhere('text', 'like', '%' . $word . '%');
                    }
                }
            });
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
    
    public function edit($id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);

        if ($user->id != $post->user_id) {
            return back();
        } else {
            return view('posts.edit', ['post' => $post]);
        }
    }

    public function update(PostRequest $request, $id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);

        if ($user->id != $post->user_id) {
            return back();
        } else {
            $post->text = $request->text;
            $post->save();
            return redirect()->route('welcome');
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
