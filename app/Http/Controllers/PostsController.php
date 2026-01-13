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
        $query->with(['user', 'replies.user', 'tags']);
        // 検索やタグ絞り込みをしていない場合、リプライ（返信）が一覧のトップに混ざらないように親投稿のみ取得する
        if (empty($keyword) && empty($tag)) {
            // 通常時：親投稿のみ
            $query->whereNull('parent_id');
        } else {
            // 検索時：キーワードかタグに一致する投稿を探す
            $searchQuery = Post::query();
        
            if (!empty($keyword)) {
                $searchQuery->where('content', 'LIKE', "%{$keyword}%");
            }
            if (!empty($tag)) {
                $searchQuery->whereHas('tags', function ($q) use ($tag) {
                    $q->where('name', $tag);
                });
            }
            // ヒットした投稿の「親ID」を集める（親がいない場合は自分のID）
            $targetIds = $searchQuery->get()->map(function ($post) {
                return $post->parent_id ?? $post->id;
            })->unique();

            // 集めた親IDの投稿を表示対象にする
            $query->whereIn('id', $targetIds);
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
        $post->parent_id = $request->parent_id;
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
        return back();
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
        return redirect('/');
    }
    
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }

        return redirect('/')->with('success', '投稿を削除しました');
    }
}
