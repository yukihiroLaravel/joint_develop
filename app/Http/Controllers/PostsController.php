<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller

{
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->paginate(10);
    
        return view('welcome', ['posts' => $posts]);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return back();
    }
    public function edit($id)
    {
        $user= new User();
        $user = \Auth::user();
        $post = Post::findOrFail($id); 
        $data=[
            'user' => $user,
            'post' => $post,
        ];
        return view('posts.edit', $data);
    }

    public function update(Request $request, $id)
    {
        // $post = \Auth::user();
        $post = Post::findOrFail($id);

        $validatedData = $request->validate([
            'text' => 'required|max:255',
            'id' => ['required', 'string', 'email', 'max:255',
                    // Rule::unique('user')->ignore(Auth::id())
                ],
        ]);
    
        $post->id = $request->user()->id;
        $post->text = $request->text;
        $post->save();
        return back();
    }
}