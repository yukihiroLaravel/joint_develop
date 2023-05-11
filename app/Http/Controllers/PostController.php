<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;
use App\User;
use App\Http\Requests\PostRequest;
class PostController extends Controller
{

    public function index(Request $request)
    {      
        $search = $request->input('keyword');
        $query = Posts::query();

        if (!empty($search)) {
            $query->where('text', 'LIKE', "%{$search}%");
        } 
    
        $posts =   $query->orderBy('id','desc')->paginate(10);
        return view('welcome', ['posts' => $posts,'search' => $search]);
    }

    public function store(PostRequest $request)
    {
        $post = new Posts;
        $post->text = $request->contents;
        $post->user_id = $request->user()->id;
        $post->save();
        return back()->with('successMessage', '投稿に成功しました。');
    }

    public function edit($id)
    {   
        $user = \Auth::user();
        $post = Posts::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $data = [
                'user' => $user,
                'post' => $post,
            ];
            return view('post.edit', $data);
        }
        abort(404);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Posts::findOrFail($id);
        $post->text = $request->contents;
        $post->user_id = $request->user()->id;
        $post->save();
        return redirect('')->with('successMessage', '更新しました。');
    }
    
    public function destroy($id)
    {
        $post = Posts::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return back()->with('alertMessage', '削除しました。');
    }
}
