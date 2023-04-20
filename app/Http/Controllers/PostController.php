<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;
use App\User;
use App\Http\Requests\PostRequest;
class PostController extends Controller
{
    public function index()
    {
        $posts = Posts::orderBy('id','desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
        ]);
    }

    public function store(PostRequest $request)
    {
        $post = new Posts;
        $post->text = $request->contents;
        $post->user_id = $request->user()->id;
        $post->save();
        return back();
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
        return redirect('');
    }
    
    public function destroy($id)
    {
        $post = Posts::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return back();
    }
}
