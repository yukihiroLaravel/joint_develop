<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('name')->get();
        return view('tags.index', compact('tags'));
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|max:50|unique:tags,name,' . $tag->id,
        ]);
        $tag->update(['name' => $request->name]);

        return redirect()->route('tags.index')->with('success', 'タグを更新しました');
    }

    public function destroy(Tag $tag)
    {
        // 紐付け解除
        $tag->posts()->detach();
        $tag->delete();

        return redirect()->route('tags.index')->with('success', 'タグを削除しました');
    }

    public function show(Tag $tag)
    {
        $posts = $tag->posts()->with('tags')->orderBy('id', 'desc')->paginate(10);

        return view('tags.show', compact('tag', 'posts'));
    }
}
