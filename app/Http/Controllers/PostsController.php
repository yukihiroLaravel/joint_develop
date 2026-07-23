<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Tag;
use App\Reaction;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function index(Request $request)
    {   
        $search = $request->search;

        // 投稿一覧表示用に投稿者情報とリアクション情報を取得する（Minami）
        $posts = Post::with(['user', 'reactions', 'tags'])
            ->search($search)
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends($request->all());

        // ランキング表示用にリアクション数の多い投稿を取得する(Minami)
        $rankingPosts = Post::with('user')
            ->withCount('reactions')
            ->having('reactions_count', '>', 0)
            ->orderBy('reactions_count', 'desc')
            ->take(3)
            ->get();

            // リアクション種類一覧をViewに渡すため取得する（Minami）
        $reactionTypes = Reaction::TYPES;

        return view('welcome', [
            // 投稿一覧をviewに渡す
            'posts' => $posts,

            // リアクション種類一覧をViewに渡す（Minami）
            'reactionTypes' => $reactionTypes,

            // ランキング一覧をviewに渡す(Minami)
            'rankingPosts' => $rankingPosts,
        ]);
    }

    public function show($id)
    {
        $post = Post::with(['user', 'tags', 'reactions'])
            ->findOrFail($id);

        // リアクション集計表示でも同じ順番を使うため、資料の並び順に合わせる（Reactionモデル内で定数化）
        $reactionTypes = Reaction::TYPES;
        $reactionColors = Reaction::COLORS;

        // リアクション総数を取得する(Minami)
        $totalReactions = $post->reactions()->count();

        // リアクション種類別件数を取得(Minami)
        $reactionCounts = $post->reactions()
            ->select('reaction_type')
            ->selectRaw('count(*) as count')
            ->groupBy('reaction_type')
            ->pluck('count', 'reaction_type');

        // リアクション総数をもとに、種類ごとの割合(%)を計算する(Minami)
        $reactionPercentages = [];

        foreach ($reactionTypes as $type => $label) {
            if ($totalReactions > 0) {
                $reactionPercentages[$type] = round(
                    (($reactionCounts[$type] ?? 0) / $totalReactions) * 100
                );
            } else {
                $reactionPercentages[$type] = 0;
            }
        }

        // リアクション種類別件数から最多リアクションを取得する(Minami)
        $maxReactionTypes = [];
        $maxReactionCount = $reactionCounts->max() ?? 0;

        foreach ($reactionCounts as $type => $count) {
            if ($count === $maxReactionCount && $count > 0) {
                $maxReactionTypes[] = $type;
            }
        }

        $myReaction = $post->reactions()
            ->where('user_id', Auth::id())
            ->first();

        $encouragementReactions = $post->reactions()
            ->with('user')
            ->whereHas('user')
            ->whereNotNull('encouragement')
            ->where('encouragement', '<>', '')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('posts.show', [
            'post' => $post,
            'reactionTypes' => $reactionTypes,
            'reactionColors' => $reactionColors,

            // リアクション総数をviewに渡す(Minami)
            'totalReactions' => $totalReactions,

            // リアクション種類別件数をviewに渡す(Minami)
            'reactionCounts' => $reactionCounts,

            // リアクション種類別の割合(%)をviewに渡す（Minami）
            'reactionPercentages' => $reactionPercentages,

            // 最多リアクションの種類をviewに渡す(Minami)
            'maxReactionTypes' => $maxReactionTypes,

            // 最多リアクションの件数をviewに渡す(Minami)
            'maxReactionCount' => $maxReactionCount,

            'myReaction' => $myReaction,
            'encouragementReactions' => $encouragementReactions,
        ]);
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        return view('posts.edit', [
            'post' => $post,
        ]);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        $validated = $request->validated();

        //画像を削除するチェックボックスがONの場合
        if ($request->has('delete_image') && $request->input('delete_image') == '1') {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
                $post->image_path = null;
            }
        }

        //新しい画像がアップロードされた場合　変更・差し替え
        if ($request->hasFile('image')) {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $path = $request->file('image')->store('posts', 'public');
            $post->image_path = $path;
        }

        // 投稿本文を更新
        $post->content = $validated['content'];
        $post->save();

        // 整形済みのタグ名を取得
        $tagNames = $request->tagNames();

        $this->syncTags($post, $tagNames);

        return redirect('/');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        return redirect("/");
    }

    public function store(PostRequest $request)
    {
        $validated = $request->validated();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        // 投稿を保存
        $post = $request->user()->posts()->create([
            'content' => $validated['content'],
            'image_path' => $imagePath,
        ]);

        // 整形済みのタグ名を取得
        $tagNames = $request->tagNames();

        $this->syncTags($post, $tagNames);

        return back();
    }

    private function syncTags(Post $post, array $tagNames)
    {
        // 投稿に紐づけるタグIDを格納
        $tagIds = [];

        foreach ($tagNames as $tagName) {
            // 同名タグがあれば取得、なければ新規作成
            $tag = Tag::firstOrCreate([
                'name' => $tagName,
            ]);

            $tagIds[] = $tag->id;
        }

        // 投稿とタグの紐づきを同期
        $post->tags()->sync($tagIds);
    }
}