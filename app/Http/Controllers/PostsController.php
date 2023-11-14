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
        $posts = Post::orderBy('id', 'desc')->paginate(10);

        return view('welcome',[
            'posts' => $posts,
        ]);
    }

    public function store(PostRequest $request)
    {
        $post = new Post();
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        
        // 画像の保存
        if ($request->image) {    
            $filename = $request->file('image')->getClientOriginalName();
            $post->image = $request->file('image')->storeAs('public/images', $filename);
        }

        $post->save();
        return back()->with('successMessage', '・投稿に成功しました。');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
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

         if ($request->image) {
            $filename = $request->file('image')->getClientOriginalName();
            $post->image = $request->file('image')->storeAs('public/images', $filename);
         } else {
            $post->image = null;
         }

         $post->save();
         return redirect('/')->with('editMessage', '・投稿編集に成功しました。');
     }
} 
