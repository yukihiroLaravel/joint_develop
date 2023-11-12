<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Post::query();

        // 検索機能
        if ($search) {
            $query->where('content', 'LIKE', "%{$search}%");
        }

        $posts = $query->orderBy('id','desc')->paginate(10);
        return view('welcome',[
            'posts' => $posts,
            'search' => $search
        ]); 
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();
        return back()->with('successMessage', '・投稿に成功しました。');
    }

    public function destroy($id)
    {
        $posts = Post::findOrFail($id);
        if (\Auth::id() === $posts->user_id) {
           $posts->delete();
        }
        return back()->with('destroyMessage', '・投稿削除に成功しました。');
    } 

    public function edit($id)
     {
         $post = Post::findOrFail($id);
         if (\Auth::id() === $post->user_id) {
             $data = [
                 'post' => $post,
             ];
             return view('posts.edit', $data);
         } 
         return back();
     }
     
     public function update(PostRequest $request, $id)
     {
         $post = Post::findOrFail($id);
         $post->content = $request->content;
         $post->save();
         return redirect('/')->with('editMessage', '・投稿編集に成功しました。');
     }
}
