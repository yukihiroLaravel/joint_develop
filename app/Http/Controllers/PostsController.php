<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use App\Post;
use App\Http\Requests\PostEditRequest;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('welcome', [ 
            'posts' => $posts,    
        ]);
    }

    public function store(PostRequest $request)
    {
        try { 
            $post = new Post;
            $post->content = $request->content;
            $post->user_id = \Auth::id();        
            $post->save();
            $request->session()->flash('content', '投稿を作成しました');
        } catch(\Exception $e) { 
            $request->session()->flash('error_content', '投稿が失敗しました');
        }
        return redirect('/');
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            return view('posts.edit', [
                'user' => $user,
                'post' => $post,
            ]);
        }
        return back();
    }
    
    public function update(PostEditRequest $request, $id)
    {
        try { 
            $post = Post::findOrFail($id);
            if (\Auth::id() === $post->user_id) {
                $post->content = $request->content;
                $post->save();
            }
            $request->session()->flash('content', '投稿を編集しました');
        } catch(\Exception $e) {
            $request->session()->flash('error_content', '投稿の編集が失敗しました');
        }
        return redirect('/');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $query = Post::query();
        $counter = 0;
        if($search) {
            $spaceConversion = mb_convert_kana($search, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
            foreach($wordArraySearched as $search) {
            $query->where('content', 'like', '%'.$search. '%');
            $counter++;
            }
        }
            $data = $query->orderBy('created_at', 'desc')->paginate(10);
            return view('searchs.results',[ 
                'data' => $data,
            ]);
    }
}
