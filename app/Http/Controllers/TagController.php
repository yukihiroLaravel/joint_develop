<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
use App\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::where('user_id', auth()->id())->orderBy('name')->paginate(10);
        return view('tags.index', compact('tags'));
    }

    public function update(TagRequest $request, Tag $tag)
    {
        // 作成者チェック
        if ($tag->user_id !== auth()->id()) {
            abort(403);
        }
        // 更新1回まで
        if ($tag->update_count >= 1) {
            return redirect()->route('tags.index')->withErrors()->with('error_tag_id', $tag->id);
        }
        // 同じ名前チェック
        if ($request->name === $tag->name) {
            return redirect()->route('tags.index')->withErrors(['name' => 'タグ名が変更されていません'])->withInput()->with('error_tag_id', $tag->id);
        }

        $tag->name = $request->name;
        $tag->update_count++;
        $tag->save();

        return redirect()->route('tags.index')->with('success', 'タグを更新しました');
    }

    public function destroy(Tag $tag)
    {
        if ($tag->user_id !== auth()->id()) {
            abort(403);
        }
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
