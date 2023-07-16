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
        foreach($posts as $post){        
            $user = $post->user;
            $movie = $user->movies;
        }        
        return view('welcome', [
            'posts' => $posts,
            'user' => $user,
            'movie' => $movie,                      
        ]);
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = \Auth::id();
        $post->save();
        return back()->with(['flash_msg' => '投稿しました',
                             'cls' => 'success'
                            ]);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return back()->with(['flash_msg' => '削除しました',
                             'cls' => 'danger'
                            ]);
    }
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            return view('posts.edit', [
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
        }
        return redirect('/');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');        
        $query = Post::query();
        if ($search) {
            $spaceConversion = mb_convert_kana($search, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
            foreach($wordArraySearched as $value) {                         
                $query->where('content', 'like', '%'.$value.'%');
            };
            $posts = $query->get();
                       
            if  (count($posts) > 0) {
                $posts = $query->paginate(10);                    
                return view('welcome')->with([
                    'posts' => $posts,
                    'search' => $search,
                ]);
                                      
            }else {                 
                return back()->with([
                    'flash_msg' => 'キーワードに一致する投稿が見つかりませんでした',
                    'cls' => 'light'
                ]);                            
            }                                            
        }else {
            return redirect('/')->with(['flash_msg' => 'キーワードを入力してください',
            'cls' => 'warning'
           ]);
        }        
    }       
}