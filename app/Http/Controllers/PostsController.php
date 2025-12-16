<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Tag;
use App\Http\Requests\PostRequest; 

class PostsController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();
        // タグ保存（追加部分）
        if ($request->filled('tags')) {
            $tagNames = array_unique(
                array_map('trim', explode(',', $request->tags))
            );

            $tagIds = [];

            foreach ($tagNames as $name) {
                $tag = Tag::firstOrCreate(['name' => $name]);
                $tagIds[] = $tag->id;
            }

            $post->tags()->sync($tagIds);
        }   
        return back();      
    }

    public function destroy($id)    
    {
        $user = User::findOrFail($id);        
        $user->delete();
        return redirect('/');
    }
}
