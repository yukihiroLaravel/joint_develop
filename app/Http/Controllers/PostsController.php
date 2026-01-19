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
            $matchedPosts = $searchQuery->get();
            // ヒットした投稿から「一番上の親」のIDを収集する
            $rootIds = [];
            foreach ($matchedPosts as $post) {
                $current = $post;
                // 親がいる間はずっと上に遡る（最上位を探す）
                while ($current->parent_id !== null) {
                    // 親投稿を取得（親を辿る）
                    $current = Post::find($current->parent_id);
                    if (!$current) break; // 親が見つからなければ終了
                }
                $rootIds[] = $current->id;
            }

            // 重複を除去して、その最上位親IDの投稿を表示
            $query->whereIn('id', array_unique($rootIds));
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
        $parentId = $request->parent_id;
        // 1. 本文(content)の取得
        if ($parentId) {
            $content = $request->input("content.$parentId");
        } else {
            $content = $request->content; // 親投稿用（通常の投稿フォーム）
        }

        // 2. タグ(tags)の取得
        // 親投稿なら $request->tags、返信なら $request->input("tags.$parentId") を見る
        $tagsInput = $parentId ? $request->input("tags.$parentId") : $request->input("tags.0");

        // 投稿本体の保存
        $post = new Post;
        $post->content = $content;
        $post->user_id = $request->user()->id;
        $post->parent_id = $parentId;
        $post->favorite_flag = $request->favorite_flag ? 1 : 0;
        $post->save();

        // 3. タグの保存と紐付け
        if (!empty($tagsInput)) {
            $tagNames = preg_split('/[\s\r\n]+/', $tagsInput);
            $tagNames = preg_split('/[\s\r\n]+/u', $tagsInput, -1, PREG_SPLIT_NO_EMPTY);
        
            $tagIds = [];
            
            foreach ($tagNames as $name) {
                if ($name === '') continue;
                $tag = Tag::firstOrCreate(['name' => $name]);
                $tagIds[] = $tag->id;
            }
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
