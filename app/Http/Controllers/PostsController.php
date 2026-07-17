<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Reaction;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index(Request $request)
    {   
        $search = $request->search;

        // 投稿一覧表示用に投稿者情報とリアクション情報を取得する（Minami）
        $posts = Post::with(['user', 'reactions'])
            ->search($search)
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends($request->all());

        // リアクション種類一覧をViewに渡すため取得する（Minami）
        $reactionTypes = Reaction::TYPES;

        return view('welcome', [
            // 投稿一覧をviewに渡す
            'posts' => $posts,

            // リアクション種類一覧をViewに渡す（Minami）
            'reactionTypes' => $reactionTypes,
        ]);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

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

        $post->content = $validated['content'];
        $post->save();

        return redirect('/');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        $post->delete();

        return redirect("/");
    }

    public function store(PostRequest $request)
    {
        $request->user()->posts()->create([
            'content' => $request->content,
        ]);

        return back();
    }
}