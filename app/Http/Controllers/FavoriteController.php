<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class FavoriteController extends Controller
{
    public function store($id)
    {
        \Auth::user()->favorite($id);
        session()->flash('flash_message', 'いいねしました！');
        return back();
    }

    public function destroy($id)
    {
        \Auth::user()->unfavorite($id);
        return back();
    }

    public function showModal($postId)
    {
        $post = Post::findOrFail($postId);
        $favorites = $post->favoriteUsers()->get();
        return view('modal', ['favorites' => $favorites]);
    }
}
