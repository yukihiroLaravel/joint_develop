<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Tag;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $tag = $request->input('tag');
        $query = Post::query();
        if (!empty($keyword)) {
            $query->where('content', 'LIKE', "%{$keyword}%");
        }
        if (!empty($tag)) {
            $query->whereHas('tags', function ($q) use ($tag) {
            $q->where('name', $tag);
            });
        }
        $posts = $query->orderBy('id', 'desc')->paginate(10);
        $posts->appends([
            'keyword' => $keyword,
            'tag'     => $tag,
        ]);
        $ranking_posts = $this->getRanking();
        return view('welcome', [
            'posts' => $posts,
            'ranking_posts' => $ranking_posts,
            'keyword' => $keyword,
            'tag' => $tag,
        ]);
    }

    public function store(PostRequest $request)
    {
        // 投稿本体の保存
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->favorite_flag = $request->favorite_flag ? 1 : 0;
        $post->save();
        
        // タグの保存と紐付け
        if ($request->filled('tags')) {
            $tagNames = preg_split('/\s+/', $request->tags);
            $tagNames = array_unique(
                array_map('trim', $tagNames)
            );
            $tagIds = [];
            foreach ($tagNames as $name) {
                if ($name === '') {
                    continue;
                }
                $tag = Tag::firstOrCreate([
                    'name' => $name,
                ]);
                $tagIds[] = $tag->id;
            }
            // 投稿とタグを紐付け
            $post->tags()->sync($tagIds);
        }
        return back()->with('success','投稿しました');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() !== $post->user_id) {
            return redirect('/');
        }
        return view('posts.edit', [
            'post' => $post,
        ]);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            // 本文の更新
            $post->content = $request->content;
            $post->save();
            // タグの更新
            if ($request->has('tags')) {
                $tagNames = preg_split('/\s+/', $request->tags);
                $tagNames = array_unique(array_map('trim', $tagNames));
                $tagIds = [];
                foreach ($tagNames as $name) {
                    if ($name === '') continue;
                    $tag = Tag::firstOrCreate(['name' => $name]);
                    $tagIds[] = $tag->id;
                }
                // 紐付けの同期
                $post->tags()->sync($tagIds);
            }
        }
        return redirect('/')->with('success','投稿を更新しました');
    }
    
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }

        return redirect('/')->with('danger', '投稿を削除しました');
    }
}
